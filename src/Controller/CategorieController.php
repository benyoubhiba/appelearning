<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CategorieType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CategorieController extends AbstractController
{   private $em;
    Private $categorieRepository;
    public function __construct(CategorieRepository $categorieRepository,EntityManagerInterface $em)
    {
        $this->categorieRepository = $categorieRepository ;
        $this->em = $em;
    }

     /**
     * @Route("/categorie", name="categorie")
     *  @Route("/create/categorie", name="categorie_create") 
     */
    public function index(categorie $categorie = null,Request $request,EntityManagerInterface $entityManager)
    {

        $categories=$this->categorieRepository->findAll(); 
     
        if(!$categorie){
            $categorie = new Categorie();
        }

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $entityManager->persist($categorie);
            $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('categorie');
        
        }

        return $this->render('categorie/index.html.twig', [
            "categorie"=>$categories,
            'form'  => $form->createView()
        ]);
    }
    
/**
     * @Route("/delete/categorie{id}", name="categorie_delete")
     */
   
    public function deleteCategorie(Categorie $categorie ,EntityManagerInterface $entityManager )
    {  
     $entityManager->remove($categorie);
    $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
           return $this->redirectToRoute('categorie');
        
        }
        
/**
     * @Route("/categorie/{id}", name="categorie_show")
     */
    public function showCategorie($id)
    {
        $categorie=$this->categorieRepository->find($id);
        return $this->render('Categorie/index.html.twig',[
        "categorie"=>$categorie
        ]
        );    
    }




      /**
     * @Route("getInfoCategorie/{id}", name="getInfoCategorie")
     */
    public function getInfoCategorie($id)
    {
        try{

            $categorie = $this->em->getRepository(Categorie::class)->getOneCategorie((int)$id);

            return $this->json($categorie[0],Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("codeEditCategorie", name="codeEditCategorie")
     */
    public function codeEditCategorie(Request $request)
    {
        try{
            $data = json_decode($request->getContent());

            $categorie = $this->em->find(Categorie::class,(int)$data->id);
            $categorie->setNom($data->nom);
            $categorie->setdiscription($data->discription);
            $this->em->persist($categorie);
            $this->em->flush();

            return $this->json("success",Response::HTTP_OK);
            
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
        return $this->render('Categorie/index.html.twig',[
            "categorie"=>$categorie
            ]
            ); 
    }
}
