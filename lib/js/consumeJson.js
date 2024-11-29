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
  // Si el parámetro es una URL (string), lo convierte en una Promesa fetch.
  if (typeof servicio === "string") {
    servicio = fetch(servicio, {
      headers: { "Accept": "application/json, application/problem+json" }
    });
  } else if (!(servicio instanceof Promise)) {
    throw new Error("El servicio debe ser una URL o una Promesa de tipo Response.");
  }

  try {
    // Obtiene la respuesta del servicio.
    const respuesta = await servicio;

    // Extrae los encabezados para incluirlos en el objeto de respuesta.
    const headers = respuesta.headers;

    if (respuesta.ok) {
      // Si la respuesta es válida (código HTTP 2xx).
      if (respuesta.status === 204) {
        // Si no hay contenido en la respuesta.
        return { headers, body: {} };
      }

      // Intenta parsear la respuesta como JSON.
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
      // Manejo de errores para respuestas no exitosas (códigos HTTP 4xx o 5xx).
      const texto = await respuesta.text();

      try {
        // Si la respuesta contiene un cuerpo JSON de error, parsearlo.
        const parsedError = JSON.parse(texto);
        throw new ProblemDetails(
          respuesta.status,
          headers,
          parsedError.title || respuesta.statusText,
          parsedError.type || undefined,
          parsedError.detail || texto
        );
      } catch (error) {
        // Si no se puede parsear el cuerpo, devolver el texto como detalle.
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
    // Si ocurre un error inesperado, logearlo y relanzarlo.
    console.error("Error en consumeJson:", error);
    throw error;
  }
}

// Exportar como función HTML si es necesario en el entorno original.
exportaAHtml(consumeJson);
