<?php

namespace App\Animals;

use App\Interfaces\AnimalInterface;
use App\Interfaces\EaterInterface;
use DateTimeImmutable;

abstract class AbstractAnimal implements AnimalInterface, EaterInterface
{
    protected string $type, $icon, $sound, $food;

    public function __construct(protected DateTimeImmutable $created_at, protected ?string $name, protected ?int $id) {}

    public function getNameWithDeterminer(): string
    {
        $determiner = (in_array($this->name[0], ['a','e','i','o','u','h'])) ? "L'" : "Le ";
        return $determiner . $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return htmlspecialchars($this->name);
    }

    public function getIconUrl(): string
    {
        return "/images/$this->type.png";
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCapitalizeName(): string
    {
        return ucfirst($this->name);
    }

    public function makeSound(): string
    {
        return $this->sound;
    }

    public function eat(): string
    {
       return $this->food;
    }

    public abstract function move(): string;

}
