<?php

require_once __DIR__ . "/../lib/php/NOT_FOUND.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_SERVICIO.php";

ejecutaServicio(function () {

    $servicioId = recuperaIdEntero("id");

    $pdo = Bd::pdo();

    $modelo = selectFirst(
        pdo: $pdo,
        from: SERVICIO,
        where: [SERVICIO_ID => $servicioId]
    );

    if ($modelo === false) {
        $htmlId = htmlentities($servicioId);
        throw new ProblemDetails(
            title: "Servicio no encontrado.",
            status: NOT_FOUND,
            type: "/error/servicionoencontrado.html",
            detail: "No se encontró ningún servicio con el id $htmlId."
        );
    } else {
        devuelveJson([
            "id" => ["value" => $servicioId],
            "nombre" => ["value" => $modelo[SERVICIO_NOMBRE]],
            "descripcion" => ["value" => $modelo[SERVICIO_DESCRIPCION]],
            "precio" => ["value" => $modelo[SERVICIO_PRECIO]],
            "promocion" => ["value" => $modelo[SERVICIO_PROMOCION] ?? ""]
        ]);
    }
});
