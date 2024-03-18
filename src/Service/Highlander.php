<?php
declare(strict_types = 1);

namespace App\Service;

class Highlander {

    public function say(int $threshold = 50, int $trial = 1,): array
    {

        $forecasts = [];

        for ($i=0; $i < $trial ; $i++) { 
            $draw = rand(1, 100);
            $forecast = $draw < $threshold ? "It's going to rain!" : "It's going to be sunny";
            $forecasts[] = $forecast;
        }

        return $forecasts;
    }
}

?>