<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', "1"); // rzeczy konfiguracyjne w celu wyświetlania wszystkich błędów w tracie pracy developerskiej

function dump($data)
{
    echo '<div
        style="
            display:inline-block;
            padding: 0 10px;
            border: 2px dashed royalblue;
            background: lightblue
        "
    >
    <pre>';
    print_r($data);
    echo '</pre>
    </div>
    </br>';
}
