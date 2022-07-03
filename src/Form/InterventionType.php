<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('startAt', TimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('duration')
            ->add('stopAt', TimeType::class, [
                'widget' => 'single_text',
            ])
            
            ->add('customer')
            ->add('donePaid')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
