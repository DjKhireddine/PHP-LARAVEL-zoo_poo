<?php

namespace App\Services;

use App\Animals\AbstractAnimal;

class SoundService
{
    public static function animalSound(AbstractAnimal $animal): string
    {
        return $animal->getCapitalizeName() . " fait le bruit : " . $animal->makeSound();
    }
}
