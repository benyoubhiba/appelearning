<?php

namespace App\Controller;

use App\Entity\Chapitre;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ChapitreType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ChapitreController extends AbstractController
{   private $em;
    Private $chapitreRepository;
    public function __construct(ChapitreRepository $chapitreRepository,EntityManagerInterface $em)
    {
        $this->chapitreRepository = $chapitreRepository ;
        $this->em = $em;
    }

     /**
     * @Route("/chapitre", name="chapitre")
     *  @Route("/create/chapitre", name="chapitre_create") 
     */
    public function index(chapitre $chapitre = null,Request $request,EntityManagerInterface $entityManager)
    {

        $chapitres=$this->chapitreRepository->findAll(); 
     
        if(!$chapitre){
            $chapitre = new Chapitre();
        }

        $form = $this->createForm(ChapitreType::class, $chapitre);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $entityManager->persist($chapitre);
            $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('chapitre');
        
        }

        return $this->render('chapitre/index.html.twig', [
            "chapitre"=>$chapitres,
            'form'  => $form->createView()
        ]);
    }
    
/**
     * @Route("/delete/chapitre{id}", name="chapitre_delete")
     */
   
    public function deleteChapitre(chapitre $chapitre ,EntityManagerInterface $entityManager )
    {  
     $entityManager->remove($chapitre);
    $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('chapitre');
        
        }
        
/**
     * @Route("/chapitre/{id}", name="chapitre_show")
     */
    public function showChapitre($id)
    {
        $chapitre=$this->chapitreRepository->find($id);
        return $this->render('Chapitre/index.html.twig',[
        "chapitre"=>$chapitre
        ]
        );    
    }




      /**
     * @Route("getInfochapitre/{id}", name="getInfochapitre")
     */
    public function getInfoChapitre($id)
    {
        try{

            $chapitre = $this->em->getRepository(Chapitre::class)->getOneChapitre((int)$id);

            return $this->json($chapitre[0],Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("codeEditChapitre", name="codeEditChapitre")
     */
    public function codeEditChapitre(Request $request)
    {
        try{
            $data = json_decode($request->getContent());

            $chapitre = $this->em->find(Chapitre::class,(int)$data->id);
            $chapitre->setNom($data->nom);
            $chapitre->setdiscription($data->discription);
            $chapitre->setparent($data->parent_id);
            $this->em->persist($chapitre);
            $this->em->flush();

            return $this->json("success",Response::HTTP_OK);
            
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
        return $this->render('Chapitre/index.html.twig',[
            "chapitre"=>$chapitre
            ]
            ); 
    }
}
