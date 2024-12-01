<?php

function recuperaDecimal(string $key): float {
    if (!isset($_POST[$key]) || !is_numeric($_POST[$key])) {
        throw new Exception("El valor de '$key' no es un número válido.");
    }
    return (float) $_POST[$key];
}
