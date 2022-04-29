<?php

namespace App\Form;

use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('description',TextType::class)
            ->add('image',FileType::class,array('data_class'=> null, 'label' => 'Image','label' => false))
            ->add('id_forum')
            // ->add('id_classe')
            ->add('id_certificat')
            // ->add('image', FileType::class,[
            //     'label' => 'autres images de la réalisation(fichiers JPG,PNG ou JPEG)',
            //     'multiple' => true,
            //     'mapped' => false,
            //     'required' => false,
            //     'attr' => ['id'=>'input'],
            //     'attr' => ['onchange'=>'file_changed']
            // ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
