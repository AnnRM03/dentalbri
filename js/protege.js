import { consumeJson } from "../lib/js/consumeJson.js"
import { exportaAHtml } from "../lib/js/exportaAHtml.js"
import { Sesion } from "./Sesion.js"

/**
 * @param {string} servicio
 * @param {string[]} [rolIdsPermitidos]
 * @param {string} [urlDeProtección]
 */
export async function protege(servicio, rolIdsPermitidos, urlDeProtección) {
 const respuesta = await consumeJson(servicio)
 const sesion = new Sesion(respuesta.body)
 if (rolIdsPermitidos === undefined) {
  return sesion
 } else {
  const rolIds = sesion.rolIds
  for (const rolId of rolIdsPermitidos) {
   if (rolIds.has(rolId)) {
    return sesion
   }
  }
  if (urlDeProtección !== undefined) {
   location.href = urlDeProtección
  }
  throw new Error("No autorizado.")
 }
}

exportaAHtml(protege)