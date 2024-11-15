<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/validaNombre.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd2.php";
require_once __DIR__ . "/TABLA_ADMINISTRADOR.php";

ejecutaServicio(function () {

    $nombre = validaNombre(recuperaTexto("nombre"));
    $usuario = recuperaTexto("usuario");
    $correo = recuperaTexto("correo");
    $contrasena = recuperaTexto("contrasena");

    $pdo = Bd::pdo();
    insert(pdo: $pdo, into: ADMINISTRADOR, values: [
        ADMIN_NOMBRE => $nombre,
        ADMIN_USUARIO => $usuario,
        ADMIN_CORREO => $correo,
        ADMIN_CONTRASENA => $contrasena,
    ]);

    $id = $pdo->lastInsertId();
    $encodeId = urlencode($id);

    devuelveCreated("/srv/administrador.php?id=$encodeId", [
        "id" => ["value" => $id],
        "nombre" => ["value" => $nombre],
        "usuario" => ["value" => $usuario],
        "correo" => ["value" => $correo]
    ]);
});
