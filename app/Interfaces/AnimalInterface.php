<?php

namespace App\Interfaces;

Interface AnimalInterface
{
    public function getName(): string;
    public function makeSound(): string;
    public function move(): string;
}
