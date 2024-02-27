<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationFormTestType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/location-form')]
class LocationFormController extends AbstractController
{
    #[Route('/new')]
    public function new(LocationRepository $repository, Request $request): Response
    {
        $location = new Location();

        $form = $this->createForm(LocationFormTestType::class, $location, [
            'validation_groups' => ['new'],
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $repository->save($location, true);
            
            return $this->redirectToRoute('app_locationdummy_index');
        }

        return $this->render('location_form/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}')]
    public function edit(
        LocationRepository $repository, 
        Location $location,
        Request $request
    ): Response
    {
        $form = $this->createForm(LocationFormTestType::class, $location, [
            'validation_groups' => ['edit'],
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $repository->save($location, true);
            
            return $this->redirectToRoute('app_locationdummy_index');
        }

        return $this->render('location_form/new.html.twig', [
            'form' => $form,
        ]);
    }
}
