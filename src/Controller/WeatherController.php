<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\HighlanderApiDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/weather')]
class WeatherController extends AbstractController
{

    #[Route('/highlandersays/api')]
    public function highlanderSaysApi(#[MapRequestPayload] ?HighlanderApiDTO $dto = null): Response
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
        return new JsonResponse($json);
    }

    #[Route('/highlandersays/{threshold<\d+>?50}')]
    public function highlanderSays(int $threshold): Response
    {

        $draw = rand(1, 100);
        $forecast = $draw < $threshold ? "It's going to rain!" : "It's going to be sunny";

        return $this->render('weather/highlander_says.html.twig', ['forecast' => $forecast,]);
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
}