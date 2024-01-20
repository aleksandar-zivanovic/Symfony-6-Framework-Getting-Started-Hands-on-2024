<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/weather')]
class WeatherController extends AbstractController
{

    #[Route('/highlandersays/api')]
    public function highlanderSaysApi(#[MapQueryParameter] int $threshold = 50): Response
    {
        $draw = rand(1, 100);
        $forecast = $draw < $threshold ? "It's going to rain!" : "It's going to be sunny";
        $json = [
            'forecast' => $forecast,
            'threshold' => $threshold,
            'self' => $this->generateUrl(
                route: 'app_weather_highlandersaysapi', 
                parameters: ['threshold' => $threshold],
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