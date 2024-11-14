<?php

require_once __DIR__ . "/calculaSqlDeCamposDeInsert.php";
require_once __DIR__ . "/calculaSqlDeValues.php";

function insertBridges(
 PDO $pdo,
 string $into,
 array $valuesDePadre,
 array $valueDeHijos
) {
 if (sizeof($valueDeHijos) > 0) {
  $sqlDeCamposDePadre = calculaSqlDeCamposDeInsert($valuesDePadre);
  $sqlDeCampoDeHijos = calculaSqlDeCamposDeInsert($valueDeHijos);
  $sqlDeValuesDePadre = calculaSqlDeValues($valuesDePadre);
  $sqlDeValueDeHijos = calculaSqlDeValues($valueDeHijos);
  $insert = $pdo->prepare(
   "INSERT INTO $into ($sqlDeCamposDePadre, $sqlDeCampoDeHijos)
     VALUES ($sqlDeValuesDePadre, $sqlDeValueDeHijos)"
  );
  $parametros = calculaArregloDeParametros($valuesDePadre);
  foreach ($valueDeHijos as $nombreDeValueDeHijo => $valoresDeValueDeHijo) {
   foreach ($valoresDeValueDeHijo as $valorDeValueDeHijo) {
    $parametros[":$nombreDeValueDeHijo"] = $valorDeValueDeHijo;
    $insert->execute($parametros);
   }
   break;
  }
 }
}
