import { exportaAHtml } from "../lib/js/exportaAHtml.js"
import { CUE } from "./CUE.js"
import { ROL_IDS } from "./ROL_IDS.js"

export class Sesion {

 /**
  * @param { any } objeto
  */
 constructor(objeto) {

  /**
   * @readonly
   */
  this.cue = objeto[CUE]
  if (typeof this.cue !== "string")
   throw new Error("cue debe ser string.")

  /**
   * @readonly
   */
  const rolIds = objeto[ROL_IDS]
  if (!Array.isArray(rolIds))
   throw new Error("rolIds debe ser arreglo.")
  /**
   * @readonly
   */
  this.rolIds = new Set(rolIds)

 }

}

exportaAHtml(Sesion)