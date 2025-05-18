<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Locataire;
use App\Repository\LocataireRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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
                'choice_label' => 'nomLocataire',
                'query_builder' => function (LocataireRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.nomLocataire', 'ASC');
                },
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
