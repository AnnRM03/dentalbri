import { exportaAHtml } from "./exportaAHtml.js";
import { ProblemDetails } from "./ProblemDetails.js";

/**
 * Consume un servicio web y retorna la respuesta como JSON.
 * Maneja errores de formato y de conexión.
 *
 * @param {string | Promise<Response>} servicio - La URL del servicio o una Promesa de tipo Response.
 * @returns {Promise<{ headers: Headers, body: any }>} La respuesta parseada como JSON.
 * @throws {ProblemDetails | Error} Si ocurre un error.
 */
export async function consumeJson(servicio) {
  if (typeof servicio === "string") {
    servicio = fetch(servicio, {
      headers: { "Accept": "application/json, application/problem+json" },
    });
  } else if (!(servicio instanceof Promise)) {
    throw new Error(
      "El servicio debe ser una URL o una Promesa de tipo Response."
    );
  }

  try {
    const respuesta = await servicio;
    const headers = respuesta.headers;

    if (respuesta.ok) {
      if (respuesta.status === 204) {
        return { headers, body: {} };
      }

      const texto = await respuesta.text();
      try {
        return { headers, body: JSON.parse(texto) };
      } catch {
        throw new ProblemDetails(
          respuesta.status,
          headers,
          "El contenido de la respuesta no es un JSON válido.",
          "/error/errorinterno.html",
          texto
        );
      }
    } else {
      const texto = await respuesta.text();
      try {
        const parsedError = JSON.parse(texto);
        throw new ProblemDetails(
          respuesta.status,
          headers,
          parsedError.title || respuesta.statusText,
          parsedError.type || undefined,
          parsedError.detail || texto
        );
      } catch (error) {
        throw new ProblemDetails(
          respuesta.status,
          headers,
          respuesta.statusText,
          undefined,
          texto
        );
      }
    }
  } catch (error) {
    console.error("Error en consumeJson:", error);
    throw error;
  }
}

// Exportar como función HTML si es necesario en el entorno original.
exportaAHtml(consumeJson);