<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

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
                $data = $this->getRequestPost();

                if (!empty($data)) {
                    $created = true;
                    $noteData = [
                        'title' => $data['title'],
                        'description' => $data['description']
                    ];
                    $this->database->createNote($noteData);
                    header('Location: /?before=created'); //dzięki temu uzyskujemy przekierowanie.
                    exit;
                }
                break;
            case 'show':
                $page = 'show';
                $id = $this->getRequestGet()['id'] ?? null;

                if (!$id) {
                    header('Location: /?error=missingNoteId');
                    exit;
                }

                try {
                    $note = $this->database->getNote((int)$id);
                } catch (NotFoundException) {
                    header('Location: /?error=noteNotFound');
                    exit;
                }
                $viewParams = [
                    'note' => $note
                ];
                break;

            default:
                $page = 'list';
                $data = $this->getRequestGet();
                $notes = $this->database->getNotes();

                $viewParams = [
                    'before' => $data['before'] ?? null,
                    'notes' => $notes ?? null,
                    'error' => $data['error'] ?? null
                ];

                break;
        }

        $this->view->render($page, $viewParams ?? []);
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
