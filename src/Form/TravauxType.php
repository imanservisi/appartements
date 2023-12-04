<?php

namespace App\Form;

use App\Entity\Entreprise;
use App\Entity\Travaux;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TravauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateTravaux', DateType::class, [
                'label' => 'Date Travaux',
                'widget' => 'single_text'
            ])
            ->add('annee', TextType::class, [
                'label' => 'Année'
            ])
            ->add('typeTravaux', TextType::class, [
                'label' => 'Type travaux'
            ])
            ->add('montantTravaux', MoneyType::class, [
                'currency' => 'EUR'
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'nomEntreprise'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Travaux::class,
        ]);
    }
}
