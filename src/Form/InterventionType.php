<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Intervention;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', EntityType::class,[
                'class' => Customer::class,
                'label' => 'Who ?'
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'When ?'
            ])
            ->add('startAt', TimeType::class, [
                'widget' => 'single_text',
            ])

            ->add('stopAt', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('duration', NumberType::class, [
                'label' => 'how many hour ?'
            ])

            ->add('donePaid');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
