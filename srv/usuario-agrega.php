<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/recuperaArray.php";
require_once __DIR__ . "/../lib/php/validaCue.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";

ejecutaServicio(function () {

    $cue = recuperaTexto("cue");
    $password = recuperaTexto("password");
    $rolIds = recuperaArray("rolIds");

    // Validar CUE
    $cue = validaCue($cue);

    // Validar que la contraseña no esté vacía
    if (empty($password)) {
        throw new Exception("La contraseña no puede estar vacía.");
    }

    // Generar hash de la contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    // Insertar el usuario con contraseña
    insert(pdo: $pdo, into: USUARIO, values: ["USU_CUE" => $cue, "USU_MATCH" => $passwordHash]);

    $usuId = $pdo->lastInsertId();

    // Asignar roles al usuario
    insertBridges(
        pdo: $pdo,
        into: USU_ROL,
        valuesDePadre: ["USU_ID" => $usuId],
        valueDeHijos: ["ROL_ID" => $rolIds]
    );

    $pdo->commit();

    $encodeUsuId = urlencode($usuId);
    devuelveCreated("/srv/usuario.php?id=$encodeUsuId", [
        "id" => ["value" => $usuId],
        "cue" => ["value" => $cue],
        "rolIds" => ["value" => $rolIds],
    ]);
});
