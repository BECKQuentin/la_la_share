<?php

namespace App\Form;

use App\Entity\Musics;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MusicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('artist', TextType::class, [
                'label' => 'Artiste'
            ])
            ->add('image', FileType::class, [
                'label' => 'Pochette de l\'album',
                'mapped' => false,
            ])
            ->add('audio', FileType::class, [
                'label' => 'Choisir une musique',
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter une musique',
                'attr' => [
                    'class' => 'btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Musics::class,
        ]);
    }
}
