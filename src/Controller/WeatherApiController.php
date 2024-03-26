<?php

namespace App\Controller;

use App\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1/weather')]
class WeatherApiController extends AbstractController
{
    #[Route('/json/{id}', name: 'app_weather_api')]
    // public function jsonAction(Location $location): JsonResponse
    public function jsonAction(Location $location): Response
    {
        $data = [
            'id' => $location->getId(), 
            'name' => $location->getName(), 
            'country' => $location->getCountryCode(), 
        ];

        foreach($location->getForecasts() as $forecast) {
            $data['forecasts'][$forecast->getDate()->format('Y-m-d')] = [
                'celsius' => $forecast->getCelsius(),
            ];
        }

        // return $this->json($data);
        // return new JsonResponse($data);

        $json = json_encode($data);
        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route('/jsont/{id}')]
    public function jsont(Location $location): Response
    {
        $content = $this->renderView('weather_api/json_twig.json.twig', [
            'location' => $location,
        ]);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
    
    #[Route('/csvt/{id}')]
    public function csvTwigAction(Location $location): Response
    {
        $content = $this->renderView('weather_api/csv_twig.csv.twig', [
            'location' => $location,
        ]);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;
    }

    #[Route('/serializer/json/{id}')]
    public function serializerJson(
        Location $location, 
        SerializerInterface $serializer,    
    ): Response
    {
       $content = $serializer->serialize($location, 'json', [
        AbstractNormalizer::IGNORED_ATTRIBUTES => ['location'],
       ]);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'applicaion/json');

        return $response;
    }

    #[Route('/serializer/yaml/{id}')]
    public function serializerYaml(
        Location $location, 
        SerializerInterface $serializer,    
    ): Response
    {
       $content = $serializer->serialize($location, 'yaml', [
        AbstractNormalizer::IGNORED_ATTRIBUTES => ['location'], 
        YamlEncoder::YAML_INLINE => 3,  // The level where you switch to inline YAML
       ]);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/yaml');

        return $response;
    }

    #[Route('/serializer/csv/{id}')]
    public function serializerCsv(
        Location $location, 
        SerializerInterface $serializer,    
    ): Response
    {
       $content = $serializer->serialize($location, 'csv', [
        AbstractNormalizer::IGNORED_ATTRIBUTES => ['location'], 
       ]);

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;
    }
}
