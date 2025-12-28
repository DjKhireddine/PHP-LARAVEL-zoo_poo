<?php

namespace App\Services;

use App\Animals\AbstractAnimal;

class FeedingService
{
    public static function feed(AbstractAnimal $animal): string
    {
        return "Le dresseur lui donne une récompense : " . $animal->getNameWithDeterminer() . " " . $animal->eat();
    }
}
