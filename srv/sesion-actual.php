<?php

require_once __DIR__ . "/../lib/php/ejecutaServicio.php";
require_once __DIR__ . "/../lib/php/devuelveJson.php";
require_once __DIR__ . "/protege.php";

ejecutaServicio(function () {
 devuelveJson(protege());
});
