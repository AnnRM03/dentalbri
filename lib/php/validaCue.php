<?php

require_once __DIR__ . "/BAD_REQUEST.php";
require_once __DIR__ . "/ProblemDetails.php";

function validaCue($cue)
{

 if ($cue === false)
  throw new ProblemDetails(
   status: BAD_REQUEST,
   title: "Falta el cue.",
   type: "/error/faltacue.html",
   detail: "La solicitud no tiene el valor de cue.",
  );

 $trimCue = trim($cue);

 if ($trimCue === "")
  throw new ProblemDetails(
   status: BAD_REQUEST,
   title: "Cue en blanco.",
   type: "/error/cuenblanco.html",
   detail: "Pon texto en el campo cue.",
  );

 return $trimCue;
}
