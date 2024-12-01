<?php

require_once __DIR__ . "/../lib/php/recuperaDecimal.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/recuperaTexto.php";
require_once __DIR__ . "/../lib/php/recuperaArray.php";
require_once __DIR__ . "/../lib/php/validaCue.php";
require_once __DIR__ . "/../lib/php/insert.php";
require_once __DIR__ . "/../lib/php/insertBridges.php";
require_once __DIR__ . "/../lib/php/devuelveCreated.php";
require_once __DIR__ . "/TABLA_SERVICIO.php";

$nombre = $_POST["nombre"] ?? null;
$descripcion = $_POST["descripcion"] ?? null;
$precio = recuperaDecimal("precio");
$promocion = $_POST["promocion"] ?? null;

if (!$nombre || !$descripcion || !$precio) {
    http_response_code(400); // Código de error para solicitud inválida
    echo json_encode(["error" => "Faltan datos obligatorios"]);
    exit;
}

$pdo = Bd::pdo();
$stmt = $pdo->prepare("
INSERT INTO SERVICIO (SERVICIO_NOMBRE, SERVICIO_DESCRIPCION, SERVICIO_PRECIO, SERVICIO_PROMOCION)
VALUES (:nombre, :descripcion, :precio, :promocion)
");


$stmt->execute([
    ":nombre" => $nombre,
    ":descripcion" => $descripcion,
    ":precio" => $precio,
    ":promocion" => $promocion
]);

echo json_encode(["success" => true]);

if (!$nombre || !$descripcion || !$precio) {
    http_response_code(400); // Solicitud inválida
    echo json_encode(["error" => "Faltan datos obligatorios"]);
    exit;
}
