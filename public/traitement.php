<?php
require_once '../vendor/autoload.php';

use App\Container;
use App\Factories\AnimalFactory;

$action = $_POST['action'];

match($action) {
    'create_animal' => createAnimal(),
    'edit_animal' => editAnimalName(),
    'delete_animal' => deleteAnimal(),
    default => throw new \Exception("Action '$action' inconnue")
};

function createAnimal(): void
{
    $animal = AnimalFactory::create(type: strtolower($_POST['animal_type']), name: $_POST['animal_name']);

    $zoo = Container::getZoo();
    $zoo->addAnimal($animal);
}

function editAnimalName(): void
{
    $zoo = Container::getZoo();
    $zoo->editAnimalName(id: $_POST['animal_id'], name: $_POST['animal_name']);
}

function deleteAnimal(): void
{
    $zoo = Container::getZoo();
    $zoo->deleteAnimal(id: $_POST['animal_id']);
}

header("Location: /");
exit;
