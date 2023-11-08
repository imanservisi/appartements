<?php

namespace App\Form;

use App\Entity\Locataire;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debutLocation', DateType::class, [
                'label' => 'Début de la location',
                'widget' => 'single_text'
            ])
            ->add('finLocation', DateType::class, [
                'label' => 'Fin de la location',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('locataire', EntityType::class, [
                'class' => Locataire::class,
                'choice_label' => 'nomLocataire'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
