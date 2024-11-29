<?php

require_once __DIR__ . "/devuelveResultadoNoJson.php";

function devuelveJson($resultado) {
    ob_start();
    $json = json_encode($resultado);

    if ($json === false) {
        error_log("Error al convertir a JSON: " . json_last_error_msg());
        ob_end_clean();
        devuelveResultadoNoJson();
    } else {
        ob_end_clean();
        http_response_code(200);
        header("Content-Type: application/json");
        echo $json;
    }
}



