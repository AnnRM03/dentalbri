<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/CUE.php";
require_once __DIR__ . "/ROL_IDS.php";

ejecutaServicio(function () {

 session_start();

 if (isset($_SESSION[CUE])) {
  unset($_SESSION[CUE]);
 }
 if (isset($_SESSION[ROL_IDS])) {
  unset($_SESSION[ROL_IDS]);
 }

 session_destroy();

 devuelveJson([]);
});
