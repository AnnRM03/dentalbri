<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaIdEntero.php";
require_once __DIR__ . "/../lib/php/delete.php";
require_once __DIR__ . "/../lib/php/devuelveNoContent.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";
require_once __DIR__ . "/TABLA_USU_ROL.php";
require_once __DIR__ . "/TABLA_DENTISTA.php";
require_once __DIR__ . "/TABLA_ESPECIALIDAD_DENTISTA.php";
require_once __DIR__ . "/TABLA_ESPECIALIDAD.php";


ejecutaServicio(function () {

 $usuId = recuperaIdEntero("id");

 $pdo = Bd::pdo();
 $pdo->beginTransaction();

 delete(pdo: $pdo, from: USU_ROL, where: [USU_ID => $usuId]);
 delete(pdo: $pdo, from: USUARIO, where: [USU_ID => $usuId]);

 $pdo->commit();

 devuelveNoContent();
});
