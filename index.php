<?php

declare(strict_types=1);

namespace App;

require_once("src/Utils/debug.php");

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = null;
}

dump($action);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="header">
        <h1>Moje notatki</h1>
    </div>
    <div class="container">
        <div class="menu">
            <ul>
                <li><a href="/">Lista notatek</a></li>
                <li><a href="/?action=create">Nowa notatka</a></li>
            </ul>

        </div>
        <div>
            <?php if ($action === 'create') :
                echo "<h3> Nowa Notatka </h3>";
            else :
                echo "<h3> Lista Notatek </h3>";
            endif; ?>
        </div>

    </div>

    <div class="footer"></div>

</body>

</html>