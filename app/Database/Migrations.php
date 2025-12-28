<?php

namespace App\Database;

use PDO;
use PDOException;

class Migrations
{
    private PDO $pdo;
    private string $dbName;

    public function __construct()
    {
        $this->dbName = $_ENV['DB_NAME'] ?? 'zoo';
        $this->pdo = DB::getConnectionWithoutDatabase();
    }

    // Exécute toutes les migrations
    public function run(): void
    {
        $this->createDatabaseIfNotExists();
        $this->pdo->exec("USE $this->dbName");
        $this->createAnimalsTableIfNotExists();
    }

    //Crée la base de données si elle n'existe pas
    private function createDatabaseIfNotExists(): void
    {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS {$this->dbName} 
                    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            throw new \RuntimeException("Erreur création DB: " . $e->getMessage());
        }
    }

    // Crée la table animals si elle n'existe pas
    private function createAnimalsTableIfNotExists(): void
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS animals (
                id INT AUTO_INCREMENT PRIMARY KEY,
                type VARCHAR(50) NOT NULL,
                name VARCHAR(100) NOT NULL,
                created_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            throw new \RuntimeException("Erreur création table: " . $e->getMessage());
        }
    }
}
