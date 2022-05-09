<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Email;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    // Cette fonction retourne tout les forums et creer un nouveau forum
  #[Route('/allemail', name: 'email')]
  public function index(Request $request,ManagerRegistry $doctrine,Email $email=null){
      //Initialisation des paramètres
      $entityManager = $doctrine->getManager();

      $allemail=$doctrine->getRepository(Email::class)->findAll();


      if($email==null){
          $email = new Email();
      }
          // Creation du formulaire
          $form=$this->createFormBuilder($email)
          // Configuration des paramètre du formulaire
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
          'form' =>$form->createView(),
          'request' =>$request
          
      ]);

  }
  /**
     * @Route("getInfoEmail/{id}", name="getInfoEmail")
     */
    public function getInfoEmail($id)
    {
        try{

            $user = $this->em->getRepository(Email::class)->getOneEmail((int)$id);

            return $this->json($user[0],Response::HTTP_OK);
        }catch(Exception $ex){
            return $this->json($ex->getMessage(),Response::HTTP_BAD_REQUEST);
        }
    }

        
          /**
     * @Route("codeEditEmail", name="codeEditEmail")
     */
    public function codeEditEmail(Request $request)
    {
        try{
            $data = json_decode($request->getContent());

            $user = $this->em->find(Email::class,(int)$data->id);
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
    public function deleteEmail($id,ManagerRegistry $doctrine) {

        $em = $this->getDoctrine()->getManager();
        $email=$doctrine->getRepository(Email::class)->find($id);

        if (!$email) {
            throw $this->createNotFoundException(
                'Il n y aucun forum avec l id suivant: ' . $id
            );
        }

        $em->remove($email);
        $em->flush();
    
        return $this->redirect($this->generateUrl('email'));

    }
}
