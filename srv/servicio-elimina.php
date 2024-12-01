<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/delete.php";
require_once __DIR__ . "/../lib/php/devuelveNoContent.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_SERVICIO.php";

ejecutaServicio(function () {
    $servicioId = recuperaIdEntero("id");

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    // Elimina el servicio de la base de datos
    delete(pdo: $pdo, from: SERVICIO, where: [SERVICIO_ID => $servicioId]);

    $pdo->commit();

    // Devuelve una respuesta sin contenido
    devuelveNoContent();
});
