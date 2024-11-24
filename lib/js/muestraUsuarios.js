import { consumeJson } from "./util.js";
import { muestraObjeto } from "./muestraObjeto.js";

// Verifica que el elemento #main existe
const mainElement = document.getElementById("main");
const listaElement = document.getElementById("lista"); // Obtén el elemento de la lista
if (mainElement) {
  mainElement.hidden = false;

  consumeJson('srv/usuarios.php')
    .then(render => {
      console.log(render); // Depuración: verifica el contenido recibido

      // Asegura que la respuesta tiene el formato esperado
      if (render && render.lista) {
        // Limpia la barra de carga
        if (listaElement) {
          listaElement.innerHTML = ""; // Limpia el contenido de "Cargando..."
        }

        // Muestra los usuarios
        muestraObjeto(document, { lista: render.lista });
      } else {
        console.error("La respuesta no contiene 'lista':", render);
      }
    })
    .catch(muestraError);
} else {
  console.error("#main no encontrado en el DOM");
}

/**
 * Muestra un error en la consola.
 * @param {Error} error 
 */
function muestraError(error) {
  console.error("Error al cargar los usuarios:", error);
}
