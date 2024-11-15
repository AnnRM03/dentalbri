<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaNombre.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd2.php";
require_once __DIR__ . "/TABLA_ADMINISTRADOR.php";

ejecutaServicio(function () {
    $id = recuperaIdEntero("id");
    $nombre = validaNombre(recuperaTexto("nombre"));
    $usuario = recuperaTexto("usuario");
    $correo = recuperaTexto("correo");
    $contrasena = recuperaTexto("contrasena");
    update(
        pdo: Bd::pdo(),
        table: ADMINISTRADOR,
        set: [
            ADMIN_NOMBRE => $nombre,
            ADMIN_USUARIO => $usuario,
            ADMIN_CORREO => $correo,
            ADMIN_CONTRASENA => $contrasena,
        ],
        where: [ADMIN_ID => $id]
    );

    devuelveJson([
        "id" => ["value" => $id],
        "nombre" => ["value" => $nombre],
        "usuario" => ["value" => $usuario],
        "correo" => ["value" => $correo]
    ]);
});
