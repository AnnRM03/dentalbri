<?php
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/recuperaArray.php";
require_once __DIR__ . "/../lib/php/validaCue.php";
require_once __DIR__ . "/../lib/php/update.php";
require_once __DIR__ . "/../lib/php/delete.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_ROL.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";

ejecutaServicio(function () {
    $usuId = recuperaIdEntero("id");
    $cue = recuperaTexto("cue");
    $rolIds = recuperaArray("rolIds");
    $password = recuperaTexto("password", opcional: true);

    $cue = validaCue($cue);

    $pdo = Bd::pdo();
    $pdo->beginTransaction();

    // Actualiza el CUE
    update(
        pdo: $pdo,
        table: USUARIO,
        set: ["USU_CUE" => $cue],
        where: ["USU_ID" => $usuId]
    );

    // Si se proporciona una contraseña, actualiza el hash
    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        update(
            pdo: $pdo,
            table: USUARIO,
            set: ["USU_MATCH" => $hash],
            where: ["USU_ID" => $usuId]
        );
    }

    // Actualiza los roles
    delete(pdo: $pdo, from: USU_ROL, where: [USU_ID => $usuId]);
    insertBridges(
        pdo: $pdo,
        into: USU_ROL,
        valuesDePadre: ["USU_ID" => $usuId],
        valueDeHijos: ["ROL_ID" => $rolIds]
    );

    $pdo->commit();

    devuelveJson([
        "id" => ["value" => $usuId],
        "cue" => ["value" => $cue],
        "rolIds" => ["value" => $rolIds],
    ]);
});
