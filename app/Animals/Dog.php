<?php

namespace App\Animals;

use App\Interfaces\EaterInterface;
use App\Interfaces\WalkableInterface;
use DateTimeImmutable;

class Dog extends AbstractAnimal implements WalkableInterface, EaterInterface
{
    protected string $type = "dog";
    protected string $icon = "fa-dog";
    protected string $sound = "Wouf";
    protected string $food = "mange des croquettes";

    public function __construct(DateTimeImmutable $created_at, ?string $name = null, ?int $id = null)
    {
        $name = empty($name) ? "Chien" : $name;
        parent::__construct(created_at: $created_at, name: $name, id: $id);
    }

    public function move(): string
    {
        return $this->walk();
    }
    public function walk(): string
    {
        return "marche sur ses quatre pattes.";
    }
}
