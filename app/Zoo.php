<?php

namespace App;

use App\Animals\AbstractAnimal;
use App\Database\Repository\AnimalRepository;

class Zoo
{

    public function __construct(private AnimalRepository $animal_repository) {}

    public function getAnimals(): array
    {
        return $this->animal_repository->getAll();
    }

    public function addAnimal(AbstractAnimal $animal): void
    {
        $this->animal_repository->create(type: $animal->getType(), name: $animal->getName());
    }

    public function editAnimalName(int $id, string $name): void
    {
        $this->animal_repository->updateName(id: $id, name: $name);
    }

    public function deleteAnimal(int $id): void
    {
        $this->animal_repository->deleteAnimal(id: $id);
    }

    public function countAnimals(): int
    {
        return count($this->getAnimals());
    }
}
