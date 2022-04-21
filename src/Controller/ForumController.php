<?php

namespace App\Controller;
use App\Entity\Forum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ForumController extends AbstractController{

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
 * @Route("/forum_edit/{id}",name="forum_edit")
 */
    public function editForum(Request $request,int $id):Response{
            
            $entityManager = $this->getDoctrine()->getManager();
            $forum = $entityManager->getRepository(Forum::class)->find($id);
      
            if (!$forum) {
                return $this->json('No project found for id' . $id, 404);
            }
             
            $content = json_decode($request->getContent());
             
            $forum->setNom($content->nom);
            $forum->setText($content->text);
            $entityManager->flush();
      
            $data =  [
                'id' => $forum->getId(),
                'nom' => $forum->getNom(),
                'text' => $forum->getText(),
            ];
              
            //return $this->json($data);
            return $this->render('forum/edit_test.html.twig', [
                'resultat' =>$this->json($data)
            ]);

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

