<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label'=> 'Nom du produit',
                'attr' => [
                   'placeholder' => 'Tapez le nom du produit ici ...' 
                ]
                
            ])
            ->add('price', MoneyType::class,[
              'label' => 'prix du produit',
              'currency' => 'EUR',
              'attr' => [
                  'placeholder' => "Prix du produit en € (EUR)."
              ] ,
              'divisor' => 100 
            ])
            ->add('description', CKEditorType::class,[
                'label' => 'Description du produit',
                'attr' => [
                    'placeholder' => "Tapez la description du produit"
                ]
            ])
            ->add('imageUrl', FileType::class,[
                'label'=>'Insérer une image',
                'mapped' => false,
                'required' => false
            ])
            ->add('category', EntityType::class,[
                'label' => 'Categorie du produit',
                'placeholder' => '--choisir une categorie--',
                'class' => Category::class,
                'choice_label' => function(Category $category){
                    return strtoupper($category->getName());
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
