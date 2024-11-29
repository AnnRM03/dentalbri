<?php
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ESPECIALIDAD.php";

ejecutaServicio(function () {
    $espId = recuperaIdEntero("id");
    $nombre = recuperaTexto("nombre");

    if (empty($nombre)) {
        throw new Exception("El nombre de la especialidad no puede estar vacío.");
    }

    $pdo = Bd::pdo();
    update(
        pdo: $pdo,
        table: ESPECIALIDAD,
        set: ["ESP_NOMBRE" => $nombre],
        where: [ESP_ID => $espId]
    );

    devuelveJson([
        "id" => ["value" => $espId],
        "nombre" => ["value" => $nombre],
    ]);
});
