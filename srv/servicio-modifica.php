<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/recuperaDecimal.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_SERVICIO.php";

ejecutaServicio(function () {

    $servicioId = recuperaIdEntero("id");
    $nombre = recuperaTexto("nombre");
    $descripcion = recuperaTexto("descripcion");
    $precio = recuperaDecimal("precio");
    $promocion = recuperaTexto("promocion", opcional: true);

    $pdo = Bd::pdo();

    update(
        pdo: $pdo,
        table: SERVICIO,
        set: [
            SERVICIO_NOMBRE => $nombre,
            SERVICIO_DESCRIPCION => $descripcion,
            SERVICIO_PRECIO => $precio,
            SERVICIO_PROMOCION => $promocion
        ],
        where: [SERVICIO_ID => $servicioId]
    );

    devuelveJson([
        "id" => ["value" => $servicioId],
        "nombre" => ["value" => $nombre],
        "descripcion" => ["value" => $descripcion],
        "precio" => ["value" => $precio],
        "promocion" => ["value" => $promocion]
    ]);
});
