<?php
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/fetchAll.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ESPECIALIDAD.php";

ejecutaServicio(function () {
    $lista = fetchAll(Bd::pdo()->query(
        "SELECT ESP_ID, ESP_NOMBRE
         FROM ESPECIALIDAD
         ORDER BY ESP_NOMBRE"
    ));

    $render = "";
    foreach ($lista as $modelo) {
        $encodeEspId = urlencode($modelo["ESP_ID"]);
        $espId = htmlentities($encodeEspId);
        $espNombre = htmlentities($modelo["ESP_NOMBRE"]);

        $render .= "<dt><a href='modifica-especialidad.html?id=$espId'>$espNombre</a></dt>";
    }

    devuelveJson(["lista" => ["innerHTML" => $render]]);
});
