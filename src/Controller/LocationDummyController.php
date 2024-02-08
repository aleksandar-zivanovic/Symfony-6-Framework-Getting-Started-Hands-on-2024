<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/location-dummy')]
class LocationDummyController extends AbstractController
{
    #[Route('/create')]
    public function create(LocationRepository $locationRepository): JsonResponse
    {
        $location = new Location();
        $location->setName("Sirmijum")
            ->setCountryCode("RS")
            ->setLatitude(44.787197)
            ->setLongitude(20.457273);

        // $entityManagerInterface->persist($location);
        // $entityManagerInterface->flush();
        // $em = $locationRepository->getEntityManager()->flush();

        $locationRepository->save($location, true);

        return $this->json([
            'id' => $location->getId(),
        ]);
    }

    #[Route('/edit')]
    public function edit(LocationRepository $locationRepository): JsonResponse 
    {
        $location = $locationRepository->find(7);
        $location->setName("Singidunum");
        $locationRepository->save($location, true);

        return new JsonResponse([
            'id' => $location->getId(),
            'name' => $location->getName(),
        ]);
    }
}
