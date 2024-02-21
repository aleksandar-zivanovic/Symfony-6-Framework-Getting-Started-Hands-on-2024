<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LocationFormTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('countryCode', ChoiceType::class, [
                'choices' => [
                    '' => null,
                    'Poland' => 'PL',
                    'France' => 'FR',
                    'Germany' => 'DE',
                    'Spain' => 'ES',
                    'United Kingdom' => 'UK',
                    'United States' => 'US',
                    'India' => 'IN',
                ]
            ])
            ->add('latitude', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'min' => -90,
                    'max' => 90,
                    'step' => 0.1,
                ]
            ])
            ->add('longitude', NumberType::class, [
                'html5' => true,
                'attr' => [
                    'min' => 180,
                    'max' => -180,
                    'step' => 0.1,
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
