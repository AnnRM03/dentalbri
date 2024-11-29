<?php
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ESPECIALIDAD.php";

ejecutaServicio(function () {
    $espId = recuperaIdEntero("id");

    $modelo = selectFirst(
        pdo: Bd::pdo(),
        from: ESPECIALIDAD,
        where: [ESP_ID => $espId]
    );

    if (!$modelo) {
        throw new Exception("Especialidad no encontrada.");
    }

    devuelveJson([
        "id" => ["value" => $modelo[ESP_ID]],
        "nombre" => ["value" => $modelo[ESP_NOMBRE]],
    ]);
});
