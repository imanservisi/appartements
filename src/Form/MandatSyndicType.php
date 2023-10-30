<?php

namespace App\Form;

use App\Entity\MandatSyndic;
use App\Entity\Residence;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MandatSyndicType extends AbstractType
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
            // ->add('residence', EntityType::class, [
            //     'class' => Residence::class,
            //     'choice_label' => 'nomResidence'
            // ])
            ->add('syndic')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MandatSyndic::class,
        ]);
    }
}
