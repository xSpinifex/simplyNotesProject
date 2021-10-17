<?php

declare(strict_types=1);

namespace App;

use IntlBreakIterator;

require_once("src/Utils/debug.php");
require_once("src/View.php");

const DEFAULT_ACTION = "list";

$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$viewParams = [];

switch ($action) {
    case 'create':
        $page = 'create';
        $created = false;
        if (!empty($_POST)) {
            $viewParams = [
                'title' =>   $_POST['title'],
                'description' => $_POST['description']
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
