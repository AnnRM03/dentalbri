import { consumeJson } from "./util.js";
import { muestraObjeto } from "./muestraObjeto.js";

const mainElement = document.getElementById("main");
const listaElement = document.getElementById("lista");

if (mainElement) {
  mainElement.hidden = false;

  consumeJson("srv/especialidades.php")
    .then((render) => {
      console.log(render);

      if (render && render.lista) {
        if (listaElement) {
          listaElement.innerHTML = ""; // Limpia el contenido de "Cargando..."
        }

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
  console.error("Error al cargar las especialidades:", error);
}
