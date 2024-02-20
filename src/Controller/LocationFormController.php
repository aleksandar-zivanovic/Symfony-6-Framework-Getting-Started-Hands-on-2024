<?php

namespace App\Controller;

use App\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/location-form')]
class LocationFormController extends AbstractController
{
    #[Route('/new')]
    public function new(): Response
    {
        $location = new Location();

        $form = $this->createFormBuilder($location)
            ->add('name', TypeTextType::class)
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
            ])
            ->getForm();


        return $this->render('location_form/new.html.twig', [
            'form' => $form,
        ]);
    }
}
