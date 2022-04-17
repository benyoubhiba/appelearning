<?php

namespace App\Controller;

use CategorieparentType;
use App\Entity\CategorieParent;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieParentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieParentController extends AbstractController
{  private $em;
    Private $categorieParentRepository;
    public function __construct(CategorieParentRepository $categorieparentRepository,EntityManagerInterface $em)
    {
        $this->categorieparentRepository = $categorieparentRepository ;
        $this->em = $em;
    }
 /**
     * @Route("/categorieparent", name="categorieparent")
     *  @Route("/create/categorieparent", name="categorieparent_create") 
     */
    public function index(categorieparent $categorieparent= null,Request $request,EntityManagerInterface $entityManager)
    {

        $categorieparents=$this->categorieparentRepository->findAll(); 
     
        if(!$categorieparent){
            $categorieparent = new Categorieparent();
        }

        $form = $this->createForm(CategorieparentType::class, $categorieparent);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $entityManager->persist($categorieparent);
            $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('categorieparent');
        
        }

       
        return $this->render('categorie_parent/index.html.twig', [
            "categorieparent"=>$categorieparents,
            'form'  => $form->createView()
        ]);
    }

/**
     * @Route("/delete/categorieparent{id}", name="categorieparent_delete")
     */
   
    public function deleteCategorieParent(CategorieParent $categorieparent ,EntityManagerInterface $entityManager )
    {  
     $entityManager->remove($categorieparent);
    $entityManager->flush();

           return $this->redirectToRoute('categorieparent');
        
        }
        
/**
     * @Route("/categorieparent/{id}", name="categorieparent_show")
     */
    public function showCategorieParent($id)
    {
        $categorieparent=$this->categorieparentRepository->find($id);
        return $this->render('categorie_parent/index.html.twig',[
        "categorieparent"=>$categorieparent
        ]
        );    
    }

      /**
     * @Route("getInfoCategorieParent/{id}", name="getInfoCategorieParent")
     */
    public function getInfoCategorieParent($id)
    {
        try{

            $categorieparent = $this->em->getRepository(CategorieParent::class)->getOneCategorieParent((int)$id);

            return $this->json($categorieparent[0],Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("codeEditCategorieParent", name="codeEditCategorieParent")
     */
    public function codeEditCategorieParent(Request $request)
    {
        try{
            $data = json_decode($request->getContent());

            $categorieparent = $this->em->find(CategorieParent::class,(int)$data->id);
            $categorieparent->setNom($data->nom);
            $categorieparent->setdiscription($data->discription);
            $this->em->persist($categorieparent);
            $this->em->flush();

            return $this->json("success",Response::HTTP_OK);
            
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
        return $this->render('categorie_parent/index.html.twig',[
            "categorieparent"=>$categorieparent
            ]
            ); 
    }


































      
    
}
