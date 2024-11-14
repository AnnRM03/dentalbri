<?php

require_once __DIR__ . "/../lib/php/ProblemDetails.php";
require_once __DIR__ . "/CUE.php";
require_once __DIR__ . "/ROL_IDS.php";
require_once __DIR__ . "/ROL_ID_CLIENTE.php";
require_once __DIR__ . "/Sesion.php";

const NO_AUTORIZADO = 401;

function protege(?array $rolIdsPermitidos = null)
{

 session_start();

 $cue = isset($_SESSION[CUE]) ? $_SESSION[CUE] : "";
 $rolIds = isset($_SESSION[ROL_IDS]) ? $_SESSION[ROL_IDS] : [];
 $sesion = new Sesion($cue, $rolIds);

 if ($rolIdsPermitidos === null) {

  return $sesion;
 } else {

  foreach ($rolIdsPermitidos as $rolId) {
   if (array_search($rolId, $rolIds, true) !== false) {
    return $sesion;
   }
  }

  throw new ProblemDetails(
   status: NO_AUTORIZADO,
   type: "/error/noautorizado.html",
   title: "No autorizado.",
   detail: "No está autorizado para usar este recurso.",
  );
 }
}
