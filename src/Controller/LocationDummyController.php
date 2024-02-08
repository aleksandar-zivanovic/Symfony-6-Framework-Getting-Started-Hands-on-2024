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
    public function create(EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $location = new Location();
        $location->setName("Beograd")
            ->setCountryCode("RS")
            ->setLatitude(44.787197)
            ->setLongitude(20.457273);

        $entityManagerInterface->persist($location);
        $entityManagerInterface->flush();

        return $this->json([
            'id' => $location->getId(),
        ]);
    }

    #[Route('/edit')]
    public function edit(
        LocationRepository $locationRepository, 
        EntityManagerInterface $entityManagerInterface
        ): JsonResponse 
    {
        $location = $locationRepository->find(6);
        $location->setName("Belgrade");
        $entityManagerInterface->flush();

        return new JsonResponse([
            'id' => $location->getId(),
            'name' => $location->getName(),
        ]);
    }
}
