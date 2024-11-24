<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/protege.php";

ejecutaServicio(function () {
 $sesion = protege([ROL_ID_CLIENTE]);
 devuelveJson("Hola " . $sesion->cue);
});
