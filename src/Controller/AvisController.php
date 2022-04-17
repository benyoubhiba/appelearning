<?php
namespace App\Controller;

use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Avis;


class AvisController extends AbstractController
{
    Private $avisRepository;
    public function __construct(AvisRepository $avisRepository)
    {
        $this->avisRepository = $avisRepository ;
    }

    #[Route('/avis', name: 'app_avis')]
    public function index(Request $request,EntityManagerInterface $entityManager)
    {

        $avis=$this->avisRepository->findAll(); 


        return $this->render('avis/index.html.twig', [
            "avis"=>$avis,
          
        ]);
    }


/**
     * @Route("/delete/avis{id}", name="avis_delete")
     */
   
    public function deleteUser(Avis $avis ,EntityManagerInterface $entityManager )
    {  
     $entityManager->remove($avis);
    $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('app_avis');
        
        }

}
