<?php

/**
 * Recupera los valores asociados a un
 * parámetro multivaluado; por ejemplo, un
 * grupo de checkbox, recibido en el servidor
 * por medio de GET, POST o cookie.
 * 
 * Si no se recibe el parámetro, devuelve [].
 * 
 * Si el valor recibido no es un arreglo, lo
 * coloca dentro de uno.
 */
function recuperaArray(string $parametro)
{
 if (isset($_REQUEST[$parametro])) {
  $valor = $_REQUEST[$parametro];
  return is_array($valor)
   ? $valor
   : [$valor];
 } else {
  return [];
 }
}
