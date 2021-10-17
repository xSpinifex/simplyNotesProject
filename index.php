<?php

declare(strict_types=1);

namespace App;

require_once("src/Utils/debug.php");
require_once("src/View.php");

const DEFAULT_ACTION = "list";

$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$viewParams = [];

if ($action === 'create') {
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
} else {
    $page = 'list';
}

$view->render($page, $viewParams);
