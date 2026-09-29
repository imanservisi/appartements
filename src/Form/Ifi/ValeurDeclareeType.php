<?php

namespace App\Form\Ifi;

use App\Entity\Ifi\ValeurDeclaree;
use App\Entity\Lot;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValeurDeclareeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valeur')
            ->add('annee')
            ->add('lot', EntityType::class, [
                'class' => Lot::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ValeurDeclaree::class,
        ]);
    }
}
