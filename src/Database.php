<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function __construct(array $config)
    {
        $dsn = "mysql:dbname{$config['database']};{$config['host']}";
        $connection = new PDO(
            $dsn,
            $config['user'],
            $config['password']
        );
        dump($connection);
    }
}
