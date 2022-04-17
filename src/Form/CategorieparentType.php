

<?php


use App\Entity\CategorieParent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;                                        
use EasyCorp\Bundle\EasyAdminBundle\Form\Type  ;                
 use Symfony\Component\Form\ChoiceList\ChoiceList;
 use Symfony\Component\Form\Extension\Core\Type\HiddenType;
 use Symfony\Component\OptionsResolver\OptionsResolverInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;

 class CategorieparentType extends AbstractType
{
     
    public function buildForm(FormBuilderInterface $builder, array $form): void
    {
      
        {
           $builder
           ->add('nom', TextType::class)
           ->add('discription',TextType::class)
        
       ;
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieParent::class,
            
        ]);
    }
}