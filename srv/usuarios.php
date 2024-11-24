<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/fetchAll.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_USUARIO.php";

ejecutaServicio(function () {
    $lista = fetchAll(Bd::pdo()->query(
        "SELECT
            U.USU_ID,
            U.USU_CUE,
            GROUP_CONCAT(UR.ROL_ID, ', ') AS roles
        FROM USUARIO U
        LEFT JOIN USU_ROL UR
        ON U.USU_ID = UR.USU_ID
        GROUP BY U.USU_ID
        ORDER BY U.USU_CUE;"
    ));

    $render = "";
    foreach ($lista as $modelo) {
        $encodeUsuId = urlencode($modelo["USU_ID"]);
        $usuId = htmlentities($encodeUsuId);
        $usuCue = htmlentities($modelo["USU_CUE"]);
        $roles = empty($modelo["roles"])
            ? "<em>-- Sin roles --</em>"
            : htmlentities($modelo["roles"]);

        $render .= "<dt><a href='modifica.html?id=$usuId'>$usuCue</a></dt>"
                 . "<dd><a href='modifica.html?id=$usuId'>$roles</a></dd>";
    }

    devuelveJson(["lista" => ["innerHTML" => $render]]);
});
