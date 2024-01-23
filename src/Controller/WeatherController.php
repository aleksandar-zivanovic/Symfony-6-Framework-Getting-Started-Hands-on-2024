<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\HighlanderApiDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/weather')]
class WeatherController extends AbstractController
{

    #[Route('/highlandersays/api')]
    public function highlanderSaysApi(#[MapQueryString()] ?HighlanderApiDTO $dto = null): Response
    {
        if ($dto == null) {
            $dto = new HighlanderApiDTO();
            $dto->threshold = 10;
            $dto->trial = 5;
        }

        for ($i=0; $i < $dto->trial ; $i++) { 
            $draw = rand(1, 100);
            $forecast = $draw < $dto->threshold ? "It's going to rain!" : "It's going to be sunny";
            $forecasts[] = $forecast;
        }
        
        $json = [
            'forecasts' => $forecasts,
            'threshold' => $dto->threshold,
            'trial' => $dto->trial,
            'self' => $this->generateUrl(
                route: 'app_weather_highlandersaysapi', 
                parameters: ['threshold' => $dto->threshold],
                referenceType: UrlGeneratorInterface::ABSOLUTE_PATH,
            ),
        ];
        // return new JsonResponse($json);
        return $this->json($json);
    }

    #[Route('/highlandersays/{threshold<\d+>}')]
    public function highlanderSays(
        Request $request, 
        RequestStack $requestStack, 
        ?int $threshold = null): Response
    {

        $session = $requestStack->getSession();
        if ($threshold) {
            $session->set('threshold', $threshold);
            $this->addFlash("info", "You set threshold to $threshold");
        } else {
            $session->get('threshold', 50);
        }

        $trials = $request->get(key: 'trials', default: 1);

        $forecasts = [];

        for ($i = 0; $i < $trials; $i++) {
            $draw = random_int(0, 100);
            $forecast = $draw < $threshold ? "It's going to rain" : "It's going to be sunny";
            $forecasts[] = $forecast;
        }

        return $this->render('weather/highlander_says.html.twig', [
            'forecasts' => $forecasts,
            'threshold' => $threshold,
        ]);
    }

    #[Route('/highlandersays/{guess}')]
    public function highlanderSaysGuess($guess): Response
    {
        $forecast ="It's going to $guess!";

        return $this->render('weather/highlander_says.html.twig',
            [
                'forecast' => $forecast,
            ]
        );
    }

    #[Route('/{countryCode}/{location}')]
    public function forecastForLocation(string $countryCode, string $location): Response
    {
        $dummyData = [
            [
                'Date' => '2024-01-23', 
                'Temperature' => '-4',
                'Feels Like' => '2',
                'Pressure' => 1000,
                'Humidity' => '20%',
                'Wind' => '3.5 m/s',
                'Cloudiness' => '75%',
                'Icon' => 'snow',
            ], 
            [
                'Date' => '2024-01-24', 
                'Temperature' => '3',
                'Feels Like' => '2',
                'Pressure' => 9000,
                'Humidity' => '70%',
                'Wind' => '1.1 m/s',
                'Cloudiness' => '25%',
                'Icon' => 'sun',
            ],        
        ];
        
        $filter = fn (string $value, $location) => str_contains(haystack: $location, needle: $value) ? str_replace($value, ' ', $location) : $location;
        $remove = ['_', '-'];

        for ($i=0; $i < count($remove); $i++) { 
            $location = $filter($remove[$i], $location);
        }

        $location = trim(ucwords($location));

        return $this->render('weather/forecast.html.twig', [
            'countryCode' => strtoupper($countryCode), 
            'location' => $location, 
            'forecasts' => $dummyData,
        ]);
    }
}