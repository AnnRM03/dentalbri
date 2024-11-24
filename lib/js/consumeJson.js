import { exportaAHtml } from "./exportaAHtml.js";
import { ProblemDetails } from "./ProblemDetails.js";

/**
 * Consume un servicio web y retorna la respuesta como JSON.
 * Maneja errores de formato y de conexión.
 * 
 * @param { string | Promise<Response> } servicio
 * @returns {Promise<{ headers: Headers, body: any }>} Respuesta parseada.
 * @throws {ProblemDetails | Error} Si ocurre un error.
 */
export async function consumeJson(servicio) {
  // Si la entrada es una URL, convierte a una promesa de fetch.
  if (typeof servicio === "string") {
    servicio = fetch(servicio, {
      headers: { "Accept": "application/json, application/problem+json" }
    });
  } else if (!(servicio instanceof Promise)) {
    throw new Error("El servicio debe ser una URL o una Promesa de tipo Response.");
  }

  // Espera la respuesta del servidor.
  const respuesta = await servicio;
  const headers = respuesta.headers;

  if (respuesta.ok) {
    // Respuesta válida.
    if (respuesta.status === 204) {
      // Sin contenido en el cuerpo de la respuesta.
      return { headers, body: {} };
    } else {
      const texto = await respuesta.text();
      try {
        // Intenta parsear el cuerpo como JSON.
        return { headers, body: JSON.parse(texto) };
      } catch (error) {
        // Si el texto no es JSON, lanza un error ProblemDetails.
        throw new ProblemDetails(
          respuesta.status,
          headers,
          "El contenido de la respuesta no es JSON.",
          "/error/errorinterno.html",
          texto
        );
      }
    }
  } else {
    // Manejo de errores cuando la respuesta no es válida.
    const texto = await respuesta.text();

    if (texto === "") {
      throw new ProblemDetails(
        respuesta.status,
        headers,
        respuesta.statusText,
        undefined,
        "No se recibió información adicional sobre el error."
      );
    } else {
      try {
        // Si es un error en formato JSON, parsea el texto.
        const { title, type, detail } = JSON.parse(texto);
        throw new ProblemDetails(
          respuesta.status,
          headers,
          typeof title === "string" ? title : respuesta.statusText,
          typeof type === "string" ? type : undefined,
          typeof detail === "string" ? detail : undefined
        );
      } catch (error) {
        if (error instanceof ProblemDetails) {
          // Si ya es un ProblemDetails, simplemente lo lanza.
          throw error;
        } else {
          throw new ProblemDetails(
            respuesta.status,
            headers,
            respuesta.statusText,
            undefined,
            texto
          );
        }
      }
    }
  }
}

// Exporta la función como HTML (según tu implementación original).
exportaAHtml(consumeJson);
