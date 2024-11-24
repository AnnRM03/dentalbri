<?php

/**
 * Recupera el texto de un parámetro enviado al
 * servidor por medio de GET, POST o cookie.
 * 
 * Si el parámetro no se recibe, devuelve false o null si es opcional.
 */
function recuperaTexto(string $parametro, bool $opcional = false): false|string|null
{
    if (isset($_REQUEST[$parametro]) && trim($_REQUEST[$parametro]) !== '') {
        return trim($_REQUEST[$parametro]);
    }

    if ($opcional) {
        return null; // Retorna null si el parámetro es opcional y no está presente.
    }

    return false; // Retorna false si el parámetro no está presente y no es opcional.
}
