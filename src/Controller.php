<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;

require_once("src/View.php");
require_once("src/Database.php");
require_once("src\Exceptions\ConfigurationException.php");

class Controller
{

    private const DEFAULT_ACTION = "list";

    private static array $configuration = [];
    private Database $database;
    private array $request;
    private View $view;


    public static function initConfiguration(array $configuration): void
    {
        self::$configuration =  $configuration;
    }


    public function __construct(array $request)
    {
        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException('Wystąpił dataBase error');
        } else {
            $configurationDb = self::$configuration['db'];
        }

        $this->database = new Database($configurationDb);
        $this->request = $request;
        $this->view = new View();
    }


    public function run(): void
    {
        $viewParams = [];

        switch ($this->action()) {
            case 'create':
                $page = 'create';
                $created = false;
                $data = $this->getRequestPost();
                if (!empty($data)) {
                    $viewParams = [
                        'title' =>   $data['title'],
                        'description' => $data['description']
                    ];
                    $created = true;
                    $this->database->createNote($data);
                    header('Location: /'); //dzięki temu uzyskujemy przekierowanie.
                }
                $viewParams['created'] = $created;


                break;
            case 'show':
                $viewParams = [
                    'title' =>  "Tytuł notatki z bazy danych",
                    'description' => "opis Notatki z Bazy Danych"
                ];
                break;
            default:
                $page = 'list';
                break;
        }

        $this->view->render($page, $viewParams);
        exit('stop');
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }

    private function action(): string
    {
        return $this->getRequestGet()['action'] ?? self::DEFAULT_ACTION;
    }
}
