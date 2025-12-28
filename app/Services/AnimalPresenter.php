<?php

namespace App\Services;

use App\Interfaces\AnimalInterface;

class AnimalPresenter
{
    public function describe(AnimalInterface $animal): string
    {
        $description = "Un " . $animal->getName();

        if ($animal instanceof \App\Interfaces\WalkableInterface) {
            $description .= " terrestre";
        }
        if ($animal instanceof \App\Interfaces\FlyableInterface) {
            $description .= " aérien";
        }
        if ($animal instanceof \App\Interfaces\SwimmableInterface) {
            $description .= " aquatique";
        }

        return $description;
    }
}
