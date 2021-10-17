<?php

declare(strict_types=1);

namespace App;

require_once("src/View.php");

class Controller
{

    private const DEFAULT_ACTION = "list";

    private array $request;
    private View $view;

    public function __construct(array $request,)
    {
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
