<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/StorageException.php");

use App\Exception\ConfigurationException;
use PDO;
use Throwable;
use App\Exception\StorageException;
use PDOException;

class Database
{
    public function __construct(array $config)
    {
        try {

            $this->validateConfig($config);

            $dsn = "mysql:dbname{$config['database']};{$config['host']}";
            $connection = new PDO(
                $dsn,
                $config['user'],
                $config['password']
            );
        } catch (PDOException $e) {
            throw new StorageException('Connection error');
        }
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
