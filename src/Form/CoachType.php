<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CoachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('motto')
            ->add('rating')
            ->add('tier', ChoiceType::class,
                [
                    'choices'=>[
                        'Challenger'=>'Challenger',
                        'Master'=>'Master',
                        'Platinum'=>'Platinum',
                        'Silver'=>'Silver'
                    ],
                ])
            ->add('imageURL', FileType::class, [
                'data_class' => null
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coach::class,
        ]);
    }
}

