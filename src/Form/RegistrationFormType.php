<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('firstName', TextType::class,[
                'required' => false,
                'label' => 'Votre prenom',
                'attr' => [
                    'placeholder' => 'Tapez votre prenom'
                ]
            ])
            ->add('lastName', TextType::class,[
                'required' => false,
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Tapez votre nom'
                ]
            ])
            ->add('country', TextType::class,[
                'required' => false,
                'label' => 'Pays de livraison',
                'attr' => [
                    'placeholder' => 'Tapez le Pays de livraison...'
                ]
            ])
            ->add('city', TextType::class,[
                'required' => false,
                'label' => 'Ville de livraison',
                'attr' => [
                    'placeholder' => 'Tapez la ville de livraison...'
                ]
            ])
            ->add('postalCode', TextType::class,[
                'required' => false,
                'label' => 'Code postal de livraison',
                'attr' => [
                    'placeholder' => 'Tapez votre code postal...'
                ]
            ])
            ->add('street', TextType::class,[
                'required' => false,
                'label' => 'Adresse de livraison',
                'attr' => [
                    'placeholder' => 'Tapez votre adressede livraison...'
                ]
            ])
            ->add('phoneNumber', TextType::class,[
                'required' => false,
                'label' => 'Numero de telephone',
                'attr' => [
                    'placeholder' => 'Tapez votre numero de telephone...'
                ]
            ])
            ->add('email', EmailType::class,[
                'required' => false,
                'label' => 'Votre email',
                'attr' => [
                    'placeholder' => 'Tapez votre email'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot de passe ne sont pas similaire.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'mapped' => false,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer votre mot de passe'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
