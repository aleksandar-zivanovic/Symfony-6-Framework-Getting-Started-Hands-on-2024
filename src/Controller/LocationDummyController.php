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

    #[Route('/remove/{id}')]
    public function remove(
        LocationRepository $locationRepository, 
        // EntityManagerInterface $entityManagerInterface, 
        $id,
    ): JsonResponse 
    {
        $location = $locationRepository->find($id);
        // $entityManagerInterface->remove($location);
        // $entityManagerInterface->flush();
        $locationRepository->remove($location, true);

        return new JsonResponse();
    }

    #[Route('/show/{code}')]
    public function show(LocationRepository $locationRepository, string $code): JsonResponse
    {
        /********************************************
        * pretraga po jedinstvenom parametru, 
        * kada je rezultat samo jedn red(row) iz baze
        *********************************************/
        // $location = $locationRepository->findOneBy([
        //     'name' => $name,
        // ]);


        /********************************************
        * pretraga po zajedničkom parametru, 
        * kada je rezultat više redova (rows) iz baze
        *********************************************/
        // $locations = $locationRepository->findBy([
        //     'countryCode' => $code,
        // ], [
        //     'name' => 'ASC'
        // ]);

        
        /********************************************* 
        * isto kao i prethodnim primerima, samo sto funkciju
        * nazivamo po propertiju i symfony automatski 
        * zakljucuje sta da trazi
        *********************************************/
        $locations = $locationRepository->findByCountryCode($code);
        
        $json = [];
        foreach ($locations as $location) {
            $json[] = 
                [
                    'id' => $location->getId(),
                    'name' => $location->getName(),
                    'country_code' => $location->getCountryCode(),
                    'latitude' => $location->getLatitude(),
                    'longitude' => $location->getLongitude(),
                ];
        }

        return new JsonResponse($json);
    }

    #[Route('/')]
    public function index(LocationRepository $locationRepository): JsonResponse
    {
        $locations = $locationRepository->findAll();
        // findAll() with OrderBy:
        $locations = $locationRepository->findAll(['name' => 'ASC']);

        $json = [];
        foreach ($locations as $location) {
            $json[] = 
                [
                    'id' => $location->getId(),
                    'name' => $location->getName(),
                    'country_code' => $location->getCountryCode(),
                    'latitude' => $location->getLatitude(),
                    'longitude' => $location->getLongitude(),
                ];
        }

        return new JsonResponse($json);
    }
}
