<?php

namespace App\Animals;

use App\Interfaces\WalkableInterface;
use DateTimeImmutable;

class Cat extends AbstractAnimal implements WalkableInterface
{
    protected string $type = "cat";
    protected string $icon = "fa-cat";
    protected string $sound = "Miaou";
    protected string $food = "mange des croquettes et parfois du poissons";


    public function __construct(DateTimeImmutable $created_at, ?string $name = null, ?int $id = null)
    {
        $name = empty($name) ? "Chat" : $name;
        parent::__construct(created_at: $created_at, name: $name, id: $id);
    }

    public function move(): string
    {
        return $this->walk();
    }
    public function walk(): string
    {
        return "se déplace avec élégance.";
    }
}
