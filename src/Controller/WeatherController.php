<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{

    #[Route('/weather/highlandersays/{guess}', methods:['GET', 'POST'], priority:1)]
    public function highlanderSaysGuess($guess): Response
    {
        $forecast ="It's going to $guess!";

        return $this->render('weather/highlander_says.html.twig',
            [
                'forecast' => $forecast,
            ]
        );
    }

    #[Route('/weather/highlandersays/{threshold}', methods:['GET', 'POST'], requirements: ['threshold' => '\d+'], priority:2)]
    public function highlanderSays(int $threshold = 50): Response
    {

        $draw = rand(1, 100);
        $forecast = $draw < $threshold ? "It's going to rain!" : "It's going to be sunny";

        return $this->render('weather/highlander_says.html.twig',
            [
                'forecast' => $forecast,
            ]
        );
    }
}