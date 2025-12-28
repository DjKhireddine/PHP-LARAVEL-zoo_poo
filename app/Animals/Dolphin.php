<?php

namespace App\Animals;

use App\Interfaces\SwimmableInterface;
use DateTimeImmutable;

class Dolphin extends AbstractAnimal implements SwimmableInterface
{
    protected string $type = "dolphin";
    protected string $icon = "fa-fish-fins";
    protected string $sound = "Kikiki";
    protected string $food = "mange des petits poissons";

    public function __construct(DateTimeImmutable $created_at, ?string $name = null, ?int $id = null)
    {
        $name = empty($name) ? "Dauphin" : $name;
        parent::__construct(created_at: $created_at, name: $name, id: $id);
    }

    public function move(): string
    {
        return $this->swim();
    }
    public function swim(): string
    {
        return "nage en faisant des sauts acrobatiques.";
    }
}
