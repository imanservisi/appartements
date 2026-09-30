<?php

namespace App\Form\Ifi;

use App\Entity\Ifi\TaxeFonciereIfi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxeFonciereIfiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomTFI', TextType::class, [
                'label' => 'Nom Taxe Foncière/Commentaire'
            ])
            ->add('valeur', MoneyType::class, [
                'label' => 'Montant',
                'currency' => 'EUR',
            ])
            ->add('date', DateType::class)
            ->add('annee', TextType::class, [
                'label' => 'Année'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaxeFonciereIfi::class,
        ]);
    }
}
