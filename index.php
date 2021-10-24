<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");

$configuration =  require_once("config/config.php");


$request = [
    'get' => $_GET,
    'post' => $_POST
];

try {
    // $controller = new Controller($request);
    // $controller->run();
    Controller::initConfiguration($configuration);
    (new Controller($request))->run();
} catch (ConfigurationException $e) {
    echo '<h3>Wystąpił błąd w aplikacji</h3>';
    echo $e->getMessage();
    echo '<br>Proszę się skontaktować z administratorem. Problem z konfiguracją';
} catch (AppException $e) {
    echo '<h3>Wystąpił błąd w aplikacji</h3>';
    echo $e->getMessage();
} catch (Throwable $e) {
    echo 'Wystąpił błąd w aplikacji';
    echo $e->getMessage();
}
