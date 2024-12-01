<?php
require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/fetchAll.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_SERVICIO.php";

ejecutaServicio(function () {
    try {
        $pdo = Bd::pdo();

        $lista = fetchAll($pdo->query("
            SELECT SERVICIO_ID AS ID, SERVICIO_NOMBRE AS NOMBRE, SERVICIO_DESCRIPCION AS DESCRIPCION, 
                   SERVICIO_PRECIO AS PRECIO, SERVICIO_PROMOCION AS PROMOCION
            FROM SERVICIO
            ORDER BY SERVICIO_NOMBRE
        "));

        if (!$lista) {
            $lista = [];
        }

        // Genera el contenido HTML
        $render = "";
        foreach ($lista as $servicio) {
            $id = urlencode($servicio["ID"]);
            $nombre = htmlentities($servicio["NOMBRE"]);
            $descripcion = htmlentities($servicio["DESCRIPCION"]);
            $precio = number_format((float)$servicio["PRECIO"], 2);
            $promocion = htmlentities($servicio["PROMOCION"] ?? "Sin promoción");

            $render .= "<dt><a href='servicio-modifica.html?id=$id'>$nombre</a></dt>
                        <dd>$descripcion</dd>";
        }

        devuelveJson(["lista" => ["innerHTML" => $render]]);
    } catch (Exception $e) {
        http_response_code(500);
        devuelveJson(["error" => $e->getMessage()]);
    }
});
