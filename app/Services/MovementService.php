<?php

namespace App\Services;

use App\Animals\AbstractAnimal;
use App\Interfaces\EaterInterface;

class MovementService
{
    public static function moveAnimal(AbstractAnimal $animal): string
    {
        return $animal->getNameWithDeterminer() . " " . $animal->move();
    }
}
