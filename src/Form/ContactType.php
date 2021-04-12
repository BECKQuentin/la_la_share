<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => "Nom",
            'required' => false,
        ])
        ->add('prenom', TextType::class, [
            'label' => "Prénom",
            'required' => false,
        ])
        ->add('email', EmailType::class, [
            'label' => "Email",
            'required' => false,
        ])
        ->add('sujet', TextType::class, [
            'label' => "Sujet de votre message",
            'required' => false,
        ])
        ->add('message', TextareaType::class, [
            'label' => "Votre message",
            'required' => false,
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Envoyer le message",
            'attr' => [
                'class' => 'btn-success'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
