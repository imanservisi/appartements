<?php

namespace App\Form;

use App\Entity\RegularisationPonctuelle;
use App\Entity\Residence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegularisationPonctuelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('annee', TextType::class, [
                'label' => 'Année'
            ])
            ->add('montant229bis', MoneyType::class, [
                'currency' => 'EUR',
                'required' => false
            ])
            ->add('montant230', MoneyType::class, [
                'currency' => 'EUR',
                'required' => false
            ])
            ->add('montant230bis', MoneyType::class, [
                'currency' => 'EUR',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegularisationPonctuelle::class,
        ]);
    }
}
