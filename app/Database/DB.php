<?php
namespace App\Database;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $instance = null;
    private static bool $migrationExecuted = false;

    // Créer une connexion PDO
    private static function createConnection(?string $dbName = null): PDO
    {
        $dbHost = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $dbUser = $_ENV['DB_USER'] ?? 'root';
        $dbPassword = $_ENV['DB_PASSWORD'] ?? '';

        $dsn = "mysql:host=$dbHost";
        if ($dbName !== null) {
            $dsn .= ";dbname=$dbName";
        }
        $dsn .= ";charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            return new PDO($dsn, $dbUser, $dbPassword, $options);
        } catch (PDOException $e) {
            throw new \RuntimeException('DB connection failed: ' . $e->getMessage());
        }
    }

    public static function getPdo(): PDO
    {
        self::loadEnvIfNeeded();
        // Exécuter la migration une seule fois
        if (!self::$migrationExecuted) {
            $migration = new Migrations();
            $migration->run();
            self::$migrationExecuted = true;
        }

        if (self::$instance === null) {
            $dbName = $_ENV['DB_NAME'] ?? 'zoo_db';
            self::$instance = self::createConnection($dbName);
        }

        return self::$instance;
    }

    // Charge le fichier .env si nécessaire
    private static function loadEnvIfNeeded(): void
    {
        static $envLoaded = false;

        if (!$envLoaded && class_exists(\Dotenv\Dotenv::class)) {
            $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
            $dotenv->safeLoad();
            $envLoaded = true;
        }
    }

    public static function getConnectionWithoutDatabase(): PDO
    {
        return self::createConnection();
    }
}
