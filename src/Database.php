<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/StorageException.php");

use App\Exception\ConfigurationException;
use PDO;
use App\Exception\StorageException;
use PDOException;
use Throwable;

class Database
{
    private PDO $conn;

    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->createConection($config);
        } catch (PDOException $e) {
            throw new StorageException('Connection error');
        }
    }

    public function createNote(array $date): void
    {
        try {

            echo 'Tworzymy notatkę';
            $title = $this->conn->quote($date['title']);
            $description = $this->conn->quote($date['description']);
            $created = date('Y-m-d H:i:s');

            $query = "
                INSERT INTO notes(title, description, created) 
                VALUES ($title, $description, '$created')
            ";

            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się utworzyć nowej notatki", 400, $e);
            dump($e);
            exit;
        }
    }

    private function createConection(array $config): void
    {

        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn,
            $config['user'],
            $config['password'],

            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]

        );
    }

    private function validateConfig(array $config): void
    {
        if (
            empty($config['database'])
            || empty($config['host'])
            || empty($config['user'])
            || empty($config['password'])
        ) {
            throw new ConfigurationException('Błąd z konfiguracją db. ');
        }
    }
}
