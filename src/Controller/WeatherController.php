<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\HighlanderApiDTO;
use App\Model\TestDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/weather')]
class WeatherController extends AbstractController
{

    #[Route('/highlandersays/api')]
    public function highlanderSaysApi(#[MapQueryString] ?HighlanderApiDTO $dto = null): Response
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

    #[Route('/test')]
    public function test(#[MapQueryString] ?TestDto $testDto): Response
    {
        $content = "";
        foreach ($testDto as $key => $value) {
            $content .= "$key => $value <br>";
        }

        $fullContent = "<html><body><div> $content </div></body></html>";
        
        return new Response($fullContent);
    }

    #[Route(path: '/test/MapQueryParameter')]
    public function testMapQueryParameter(
        #[MapQueryParameter] array $ids,
        #[MapQueryParameter] string $firstName,
        #[MapQueryParameter] string $required,
        #[MapQueryParameter] int $age,
        #[MapQueryParameter] string $category = 'music',
        #[MapQueryParameter] ?string $theme = null,
    ): Response
    {
        // https://127.0.0.1:8000/weather/test/MapQueryParameter?ids[]=1&ids[]=2&firstName=Ruud&required=true&age=123
        $content = "ids = " . implode(", ", $ids) . "<br>";
        $content .= "firstname =  $firstName  <br>";
        $content .= "required =  $required  <br>";
        $content .= "age =  $age  <br>";
        $content .= "category =  $category  <br>";
        $content .= "theme =  $theme  <br>";

        return new Response($content);
    }
}