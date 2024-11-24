/**
 * Realiza una solicitud HTTP y espera un JSON como respuesta.
 * @param {string} url
 * @returns {Promise<any>}
 */
export async function consumeJson(url) {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`Error en la solicitud: ${response.status}`);
    }
    return await response.json();
  }
  