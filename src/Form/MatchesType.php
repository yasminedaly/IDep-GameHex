<?php

namespace App\Form;

use App\Entity\Matches;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('team1', EntityType::class,
                [
                    'class'=>'App\Entity\Teams',
                    'choice_label'=>'teamName'
                ])
            ->add('team2', EntityType::class,
                [
                    'class'=>'App\Entity\Teams',
                    'choice_label'=>'teamName'
                ])
            ->add('matchRes')
            ->add('matchCom')
            ->add('matchDate')
            ->add('matchTime')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matches::class,
        ]);
    }
}
