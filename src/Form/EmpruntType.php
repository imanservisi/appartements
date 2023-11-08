<?php

namespace App\Form;

use App\Entity\Banque;
use App\Entity\Emprunt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debutEmprunt', DateType::class, [
                'label' => 'Début emprunt',
                'widget' => 'single_text'
            ])
            ->add('banque', EntityType::class, [
                'class' => Banque::class,
                'choice_label' => 'nomBanque'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
