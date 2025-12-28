<?php

namespace App\Database\Repository;

use App\Animals\AbstractAnimal;
use App\Factories\AnimalFactory;
use DateTimeImmutable;
use PDO;

class AnimalRepository
{
    private static ?AnimalRepository $instance = null;
    private string $table = 'animals';

    private function __construct(private PDO $pdo) {}

    // Singleton
    public static function getInstance(PDO $pdo): self
    {
        if (self::$instance === null) {
            self::$instance = new self($pdo);
        }

        return self::$instance;
    }

    // Récupérer tous les animaux
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM $this->table");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $animals = [];
        foreach ($rows as $row) {
            $created_at = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['created_at']);
            $animals[] = AnimalFactory::create(
                type: $row['type'],
                name: $row['name'],
                created_at: $created_at,
                id: $row['id']
            );
        }

        return $animals;
    }

    // Insérer un animal
    public function create(string $type, string $name): AbstractAnimal
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO $this->table (type, name, created_at) VALUES (:type, :name, :created_at)"
        );

        $createdAt = new DateTimeImmutable();
        $stmt->execute([
            "type" => $type,
            "name" => $name,
            "created_at" => $createdAt->format('Y-m-d H:i:s')
        ]);

        $id = $this->pdo->lastInsertId();
        return AnimalFactory::create(type: $type, created_at: $createdAt, name: $name, id: $id);
    }

    // Modifier le nom d'un animal
    public function updateName(int $id, string $name): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE $this->table SET name=:name WHERE id=:id"
        );

        $stmt->execute([
            "id" => $id,
            "name" => $name
        ]);
    }

    // Supprimer un animal
    public function deleteAnimal(int $id): void
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM $this->table WHERE id=:id"
        );

        $stmt->execute([
            "id" => $id
        ]);
    }


}
