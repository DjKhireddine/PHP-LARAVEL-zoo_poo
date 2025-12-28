<?php

namespace App\Animals;

use App\Interfaces\SwimmableInterface;
use DateTimeImmutable;

class Snake extends AbstractAnimal
{
    protected string $type = "snake";
    protected string $icon = "fa-worm";
    protected string $sound = "Sssssss";
    protected string $food = "mange un petit rat";

    public function __construct(DateTimeImmutable $created_at, ?string $name = null, ?int $id = null)
    {
        $name = empty($name) ? "Serpent" : $name;
        parent::__construct(created_at: $created_at, name: $name, id: $id);
    }

    public function move(): string
    {
        return $this->crawl();
    }
    public function crawl(): string
    {
        return "rampe discrètement.";
    }
}
