<?php

require_once __DIR__ . "/devuelveResultadoNoJson.php";

function devuelveJson($resultado)
{
    ob_start();

    $json = json_encode($resultado);

    if ($json === false) {
        ob_end_clean();
        devuelveResultadoNoJson();
    } else {
        ob_end_clean();
        http_response_code(200);
        header("Content-Type: application/json");
        echo $json;
    }
}


