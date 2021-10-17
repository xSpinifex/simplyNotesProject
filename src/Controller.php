<?php

declare(strict_types=1);

namespace App;

require_once("src/View.php");

class Controller
{

    private const DEFAULT_ACTION = "list";
    private array $getData;
    private array $postData;

    public function __construct(array $getData, array $postData)
    {
        $this->postData = $postData;
        $this->getData = $getData;
    }

    public function run(): void
    {
        $action = $this->getData['action'] ?? self::DEFAULT_ACTION;
        $view = new View();
        $viewParams = [];

        switch ($action) {
            case 'create':
                $page = 'create';
                $created = false;
                if (!empty($this->postData)) {
                    $viewParams = [
                        'title' =>   $this->postData['title'],
                        'description' => $this->postData['description']
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

        $view->render($page, $viewParams);
        exit('stop');
    }
}
