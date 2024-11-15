<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaNombre(false|string $nombre)
{

 if ($nombre === false)
  throw new ProblemDetails(
   status: BAD_REQUEST,
   title: "Falta el nombre.",
   type: "/error/faltanombre.html",
   detail: "La solicitud no tiene el valor de nombre."
  );

 $trimNombre = trim($nombre);

 if ($trimNombre === "")
  throw new ProblemDetails(
   status: BAD_REQUEST,
   title: "Nombre en blanco.",
   type: "/error/nombreenblanco.html",
   detail: "Pon texto en el campo nombre.",
  );

 return $trimNombre;
}
