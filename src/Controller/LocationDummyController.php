<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
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

    // same as above, but with a custom method from Location Repository
    #[Route('/show2/{name}')]
    public function show2(LocationRepository $locationRepository, $name): JsonResponse
    {
        $location = $locationRepository->findOneByName($name);

        $location ?? throw $this->createNotFoundException();
        
        $json = [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'country_code' => $location->getCountryCode(),
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
        ];

        return new JsonResponse($json);
    }

    /** Automatically Fetching Objects (EntityValueResolver) */
    /****************************************************** 
    * fetching from query parameter by EntityValueResolver
    * (when query param name matches Entity property name)
    *******************************************************/ 
    #[Route('/show3/{name}')]
    public function show3(Location $location): JsonResponse {
        $json = [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'country_code' => $location->getCountryCode(),
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
        ];

        return new JsonResponse($json);
    }

    /** Automatically Fetching Objects (EntityValueResolver) */
    /******************************************************************
    * fetching from query parameter by EntityValueResolver via MapEntity
    * (when query param name DOESN'T matche Entity property name)
    *******************************************************************/ 
    #[Route('/show4/{city}')]
    public function show4(
        #[MapEntity(mapping: ["city" => "name"])] Location $location
    ): JsonResponse {
        $json = [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'country_code' => $location->getCountryCode(),
            'latitude' => $location->getLatitude(),
            'longitude' => $location->getLongitude(),
        ];

        foreach ($location->getForecasts() as $forecast) {
            $json['forecsts'][$forecast->getDate()->format("Y-m-d")] = [
                'celsius' => $forecast->getCelsius(),
            ];
        }

        return new JsonResponse($json);
    }

    #[Route('/')]
    public function index(LocationRepository $locationRepository): JsonResponse
    {
        // $locations = $locationRepository->findAll();
        // findAll() with OrderBy:
        // $locations = $locationRepository->findAll(['name' => 'ASC']);

        $locations = $locationRepository->findAllWithForecasts();

        $json = [];
        foreach ($locations as $location) {
            $locationJson = 
                [
                    'id' => $location->getId(),
                    'name' => $location->getName(),
                    'country_code' => $location->getCountryCode(),
                    'latitude' => $location->getLatitude(),
                    'longitude' => $location->getLongitude(),
                ];
        
                foreach ($location->getForecasts() as $forecast) {
                    $locationJson['forecsts'][$forecast->getDate()->format("Y-m-d")] = [
                        'celsius' => $forecast->getCelsius(),
                    ];
                }

                $json[] = $locationJson;
        }

        return new JsonResponse($json);
    }
}
