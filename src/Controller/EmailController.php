<?php

namespace App\Controller;
use App\Entity\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EmailController extends AbstractController
{
    #[Route('/allemail', name: 'email')]
    // Cette fonction retourne tout les forums et creer un nouveau forum
    public function index(Request $request,ManagerRegistry $doctrine,Email $email=null){
        //Initialisation des paramètres
        $entityManager = $doctrine->getManager();
 
        $allemail=$doctrine->getRepository(Email::class)->findAll();


        if($email==null){
            $email = new Email();
        }
            // Creation du formulaire
            $form=$this->createFormBuilder($email)
            
                    ->add('nom',TextType::class)
                    ->add('text',TextareaType::class)
                    ->add('enregistrer',SubmitType::class)
                    ->getForm();

                    $form->handleRequest($request);

                    if($form->isSubmitted() && $form->isValid()){
                        $entityManager->persist($email);
                        $entityManager->flush();
                        return $this->redirectToRoute('email');
                    }


        return $this->render('email/index.html.twig', [
            'Allemail' => $allemail,
            'form' =>$form->createView()
        ]);

    }

     /**
     * @Route("/delete/{id}" , name="delete")
     */
    public function deleteEmail($id,ManagerRegistry $doctrine) {

        $em = $this->getDoctrine()->getManager();
        $email=$doctrine->getRepository(Email::class)->find($id);

        if (!$email) {
            throw $this->createNotFoundException(
                'Il n y aucun email avec l id suivant: ' . $id
            );
        }

        $em->remove($email);
        $em->flush();
    
        return $this->redirect($this->generateUrl('email'));

    }
}
