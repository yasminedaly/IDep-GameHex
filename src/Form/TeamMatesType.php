<?php

namespace App\Form;

use App\Entity\TeamMates;
use App\Entity\Teams;
use Doctrine\ORM\EntityRepository;
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
                    'choice_label'=>'teamName',
                    'query_builder' => function (EntityRepository $er) use ($options) {
                        $qb = $er->createQueryBuilder('t')
                            ->from(Teams::class,'teams');
                                if(isset($options['current_id'])) {
                                    $qb->Where('teams.user != :current_id')
                                        ->setParameter('current_id', $options['current_id']);
                                }
                        return $qb;
                        },
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeamMates::class,
            'current_id' => 0
        ]);
    }
}
