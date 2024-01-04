<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/weather', name: 'weather_')]
class WeatherController extends AbstractController
{

    #[Route('/highlandersays/{threshold<\d+>?50}', name: 'highlandersays')]
    public function highlanderSays(int $threshold): Response
    {

        $draw = rand(1, 100);
        $forecast = $draw < $threshold ? "It's going to rain!" : "It's going to be sunny";

        return $this->render('weather/highlander_says.html.twig',
            [
                'forecast' => $forecast,
            ]
        );
    }

    #[Route('/highlandersays/{guess}', name: 'highlanderguess')]
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