<?php

namespace App\Form;

use App\Entity\MandatGestionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MandatGestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debutMandat', DateType::class, [
                'label' => 'Début du mandat',
                'widget' => 'single_text'
            ])
            ->add('finMandat', DateType::class, [
                'label' => 'Fin du mandat',
                'widget' => 'single_text',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MandatGestionnaire::class,
        ]);
    }
}
