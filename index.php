<?php

$test = 'test';


var_dump($test);

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

dump($test);
