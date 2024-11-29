<?php
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/delete.php";
require_once __DIR__ . "/../lib/php/devuelveNoContent.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ESPECIALIDAD.php";

ejecutaServicio(function () {
    $espId = recuperaIdEntero("id");

    $pdo = Bd::pdo();
    delete(pdo: $pdo, from: ESPECIALIDAD, where: [ESP_ID => $espId]);

    devuelveNoContent();
});
