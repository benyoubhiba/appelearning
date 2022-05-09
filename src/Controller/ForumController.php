<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Forum;
use Doctrine\ORM\EntityManagerInterface;


class ForumController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
  // Cette fonction retourne tout les forums et creer un nouveau forum
  #[Route('/allforum', name: 'forum')]
  public function index(Request $request,ManagerRegistry $doctrine,Forum $forum=null){
      //Initialisation des paramètres
      $entityManager = $doctrine->getManager();

      $allforum=$doctrine->getRepository(Forum::class)->findAll();


      if($forum==null){
          $forum = new Forum();
      }
          // Creation du formulaire
          $form=$this->createFormBuilder($forum)
          // Configuration des paramètre du formulaire
                  ->add('nom',TextType::class)
                  ->add('text',TextareaType::class)
                  ->add('enregistrer',SubmitType::class)
                  ->getForm();

                  $form->handleRequest($request);

                  if($form->isSubmitted() && $form->isValid()){
                      $entityManager->persist($forum);
                      $entityManager->flush();
                      return $this->redirectToRoute('forum');
                  }


      return $this->render('forum/index.html.twig', [
          'Allforum' => $allforum,
          'form' =>$form->createView(),
          'request' =>$request
          
      ]);

  }
   /**
     * @Route("getInfoForum/{id}", name="getInfoForum")
     */
    public function getInfoForum($id)
    {
        try{

            $user = $this->em->getRepository(Forum::class)->getOneForum((int)$id);

            return $this->json($user[0],Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }
         
        
          /**
     * @Route("codeEditForum", name="codeEditForum")
     */
    public function codeEditForum(Request $request)
    {
        try{
            $data = json_decode($request->getContent());

            $user = $this->em->find(Forum::class,(int)$data->id);
            $user->setNom($data->nom);
            $user->setText($data->text);
           

            $this->em->persist($user);
            $this->em->flush();

            return $this->json("success",Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }
           


    /**
     * @Route("/delete/{id}" , name="delete")
     */
    public function deleteForum($id,ManagerRegistry $doctrine) {

        $em = $this->getDoctrine()->getManager();
        $forum=$doctrine->getRepository(Forum::class)->find($id);

        if (!$forum) {
            throw $this->createNotFoundException(
                'Il n y aucun forum avec l id suivant: ' . $id
            );
        }

        $em->remove($forum);
        $em->flush();
    
        return $this->redirect($this->generateUrl('forum'));

    }
    

    


       
    
}
