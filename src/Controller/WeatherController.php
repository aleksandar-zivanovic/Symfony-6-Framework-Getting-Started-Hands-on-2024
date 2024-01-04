<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/highlandersays', methods:['GET', 'POST'])]
    public function highlanderSays(): Response
    {

        $draw = rand(1, 100);
        $forecast = $draw < 50 ? "It's going to rain!" : "It's going to be sunny";

        return $this->render('weather/highlander_says.html.twig',
            [
                'forecast' => $forecast,
            ]
        );
    }
}