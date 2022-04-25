<?php

namespace App\Form;

use App\Entity\TeamMates;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamMatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('riotId')
            ->add('memberRole')
            ->add('memberPhone')
            ->add('memberMail')
            ->add('team',EntityType::class,
                [
                    'class'=>'App\Entity\Teams',
                    'choice_label'=>'teamName'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeamMates::class,
        ]);
    }
}
