<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/StorageException.php");
require_once("src/Exceptions/NotFoundException.php");

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
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

    public function getNote(int $id): array
    {
        try {
            $result = [];
            $query = "SELECT id, title, description, created from notes WHERE id = $id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać Notatki;', 400, $e);
        }

        if (!$note) {
            throw new NotFoundException("Nie ma takiego ID notatki", 400);
            $note = [];
        }
        return $note;
    }


    public function getNotes(): array
    {
        try {
            $notes = [];
            $query = "SELECT id, title, created from notes";
            $result =  $this->conn->query($query);
            $notes = $result->fetchAll(PDO::FETCH_ASSOC);
            return $notes;
        } catch (Throwable $e) {
            throw new StorageException("Nie udało się pobrać danych o notatkach", 400);
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
