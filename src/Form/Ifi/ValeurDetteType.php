<?php

namespace App\Form\Ifi;

use App\Entity\Emprunt;
use App\Entity\Ifi\ValeurDette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValeurDetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valeur')
            ->add('date')
            ->add('annee')
            ->add('emprunt', EntityType::class, [
                'class' => Emprunt::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ValeurDette::class,
        ]);
    }
}
