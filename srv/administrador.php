<?php

require_once __DIR__ . "/../lib/php/NOT_FOUND.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/selectFirst.php";
require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ADMINISTRADOR.php";

ejecutaServicio(function () {

    $id = recuperaIdEntero("id");

    $modelo = selectFirst(pdo: Bd::pdo(), from: ADMINISTRADOR, where: [ADMIN_ID => $id]);

    if ($modelo === false) {
        $idHtml = htmlentities($id);
        throw new ProblemDetails(
            status: NOT_FOUND,
            title: "Administrador no encontrado.",
            type: "/error/administradornoencontrado.html",
            detail: "No se encontró ningún administrador con el id $idHtml.",
        );
    }

    devuelveJson([
        "id" => ["value" => $id],
        "nombre" => ["value" => $modelo[ADMIN_NOMBRE]],
        "usuario" => ["value" => $modelo[ADMIN_USUARIO]],
        "correo" => ["value" => $modelo[ADMIN_CORREO]],
        "contrasena" => ["value" => $modelo[ADMIN_CONTRASENA]]
    ]);
});
