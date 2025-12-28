<?php

namespace App\Animals;

use App\Interfaces\SwimmableInterface;
use DateTimeImmutable;

class Fish extends AbstractAnimal implements SwimmableInterface
{
    protected string $type = "fish";
    protected string $icon = "fa-fish";
    protected string $sound = "... (silence)";
    protected string $food = "picore des petites algues";

    public function __construct(DateTimeImmutable $created_at, ?string $name = null, ?int $id = null)
    {
        $name = empty($name) ? "Poisson" : $name;
        parent::__construct(created_at: $created_at, name: $name, id: $id);
    }

    public function move(): string
    {
        return $this->swim();
    }
    public function swim(): string
    {
        return "nage tranquillement.";
    }
}
