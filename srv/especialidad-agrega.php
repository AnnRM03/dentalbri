<?php
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ESPECIALIDAD.php";

ejecutaServicio(function () {
    $nombre = recuperaTexto("nombre");

    if (empty($nombre)) {
        throw new Exception("El nombre de la especialidad no puede estar vacío.");
    }

    $pdo = Bd::pdo();
    insert(pdo: $pdo, into: ESPECIALIDAD, values: ["ESP_NOMBRE" => $nombre]);

    $espId = $pdo->lastInsertId();
    devuelveCreated("/srv/especialidad.php?id=" . urlencode($espId), [
        "id" => ["value" => $espId],
        "nombre" => ["value" => $nombre],
    ]);
});
