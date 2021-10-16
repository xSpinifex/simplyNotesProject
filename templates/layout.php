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
            <?php
            if ($page === 'create') {
                include_once("templates/pages/create.php");
            } else {
                include_once("templates/pages/list.php");
                echo "siema";
            }
            ?>
        </div>

    </div>

    <div class="footer"></div>

</body>

</html>