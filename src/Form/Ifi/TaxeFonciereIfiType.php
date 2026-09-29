<?php

namespace App\Form\Ifi;

use App\Entity\Ifi\TaxeFonciereIfi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxeFonciereIfiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valeur')
            ->add('date')
            ->add('annee')
            ->add('nomTFI')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaxeFonciereIfi::class,
        ]);
    }
}
