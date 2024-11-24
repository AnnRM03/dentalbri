<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/select.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/Bd.php";
require_once __DIR__ . "/TABLA_ROL.php";

ejecutaServicio(function () {

 $lista = select(pdo: Bd::pdo(), from: ROL, orderBy: ROL_ID);

 $render = "";
 foreach ($lista as $modelo) {
  $id = htmlentities($modelo["ROL_ID"]);
  $descripcion = htmlentities($modelo["ROL_DESCRIPCION"]);
  $render .=
   "<p>
     <label style='display: flex'>
      <input type='checkbox' name='rolIds[]' value='$id'>
      <span>
       <strong>$id</strong>
       <br>$descripcion
      </span>
     </label>
    </p>";
 }

 devuelveJson(["roles" => ["innerHTML" => $render]]);
});
