<?php

require_once __DIR__ . "/INTERNAL_SERVER_ERROR.php";

function devuelveResultadoNoJson() {
  http_response_code(500);
  header("Content-Type: application/problem+json");
  echo json_encode([
      "title" => "Error interno del servidor",
      "detail" => "El resultado no pudo convertirse a JSON.",
      "status" => 500,
      "type" => "/error/errorinterno.html"
  ]);
  exit;
}
