<?php

declare(strict_types=1);

namespace App;

require_once("src/Exceptions/StorageException.php");

use PDO;
use Throwable;
use App\Exception\StorageException;

class Database
{
    public function __construct(array $config)
    {

        try {
            $dsn = "mysql:dbname{$config['database']};{$config['host']}";

            $connection = new PDO('sss');
            // $connection = new PDO(
            //     $dsn,
            //     $config['user'],
            //     $config['password']
            // );

            dump($connection);
        } catch (Throwable $e) {
            throw new StorageException('Connection error');
        }
    }
}
