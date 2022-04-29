<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
  
    /**
     * @Route("update/image", name="upload-image")
     */
    public function updateProfilImage(Request $request,EntityManagerInterface $entityManager)
    {

$image = $request->get('image')->getData();
            
$image_name = $image->getClientOriginalName();     
$image->move($this->getParameter('images_directory'),$image_name);
$classe =$this->getClasse();
 $classe->setImage($image_name);
 $entityManager->persist($classe);
            $entityManager->flush();
     $this->addFlash(
         'info',
         'le tag et bien ajouter'

     );
     return $this->redirectToRoute('app_test');
        
        }
    }
