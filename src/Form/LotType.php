<?php

namespace App\Form;

use App\Entity\Lot;
use App\Entity\Residence;
use App\Repository\ResidenceRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomLot', TextType::class)
            ->add('dateAchat', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('dateVente', DateType::class, [
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Mise à jour',
                'attr' => [
                    'class' => 'btn btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lot::class,
        ]);
    }
}
