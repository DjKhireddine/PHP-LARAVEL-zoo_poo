<?php

namespace App\Animals;

use App\Interfaces\FlyableInterface;
use DateTimeImmutable;

class Eagle extends AbstractAnimal implements FlyableInterface
{
    protected string $type = "eagle";
    protected string $icon = "fa-crow";
    protected string $sound = "Screeeeech";
    protected string $food = "mange un petit rongeur";

    public function __construct(DateTimeImmutable $created_at, ?string $name = null, ?int $id = null)
    {
        $name = empty($name) ? "Aigle" : $name;
        parent::__construct(created_at: $created_at, name: $name, id: $id);
    }

    public function move(): string
    {
        return $this->fly();
    }
    public function fly(): string
    {
        return "vole haut dans le ciel.";
    }
}
