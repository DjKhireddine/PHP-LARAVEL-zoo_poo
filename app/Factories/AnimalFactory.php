<?php

namespace App\Factories;

use App\Animals\AbstractAnimal;
use App\Animals\Dog;
use App\Animals\Cat;
use App\Animals\Eagle;
use App\Animals\Fish;
use App\Animals\Dolphin;
use App\Animals\Snake;
use DateTimeImmutable;

class AnimalFactory
{
    public static function create(string $type, ?string $name = null, ?DateTimeImmutable $created_at = new DateTimeImmutable(), ?int $id = null): AbstractAnimal
    {
        return match($type) {
            'dog' => new Dog(created_at: $created_at, name: $name, id: $id),
            'cat' => new Cat(created_at: $created_at, name: $name, id: $id),
            'eagle' => new Eagle(created_at: $created_at, name: $name, id: $id),
            'fish' => new Fish(created_at: $created_at, name: $name, id: $id),
            'dolphin' => new Dolphin(created_at: $created_at, name: $name, id: $id),
            'snake' => new Snake(created_at: $created_at, name: $name, id: $id),
            default => throw new \Exception("Type d'animal '$type' inconnu")
        };
    }
}
