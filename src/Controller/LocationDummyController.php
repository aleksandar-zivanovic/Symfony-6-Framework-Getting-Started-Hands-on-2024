<?php

namespace App\Controller;

use App\Entity\Location;
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
        $location->setName("Belgrade")
            ->setCountryCode("RS")
            ->setLatitude(44.787197)
            ->setLongitude(20.457273);

        $entityManagerInterface->persist($location);
        $entityManagerInterface->flush();

        return $this->json([
            'id' => $location->getId(),
        ]);
    }
}
