import { htmlentities } from "../../lib/js/htmlentities.js"
import { Sesion } from "../Sesion.js"
import { ROL_ID_ADMINISTRADOR } from "../ROL_ID_ADMINISTRADOR.js"
import { ROL_ID_CLIENTE } from "../ROL_ID_CLIENTE.js"

export class MiNav extends HTMLElement {

 connectedCallback() {

  this.style.display = "block"

  this.innerHTML = /* html */
   `<nav>
     <ul style="display: flex;
            flex-wrap: wrap;
            padding:0;
            gap: 0.5em;
            list-style-type: none">
      <li><progress max="100">Cargando&hellip;</progress></li>
     </ul>
    </nav>`

 }

 /**
  * @param {Sesion} sesion
  */
 set sesion(sesion) {
  const cue = sesion.cue
  const rolIds = sesion.rolIds
  let innerHTML = /* html */ `<li><a href="index.html">Inicio</a></li>`
  innerHTML += this.hipervinculosAdmin(rolIds)
  innerHTML += this.hipervinculosCliente(rolIds)
  const cueHtml = htmlentities(cue)
  if (cue !== "") {
   innerHTML +=  /* html */ `<li>¡Hola, ${cueHtml}!</li>`
  }
  innerHTML += /* html */ `<li><a href="perfil.html">Perfil</a></li>`
  const ul = this.querySelector("ul")
  if (ul !== null) {
   ul.innerHTML = innerHTML
  }
 }

 /**
  * @param {Set<string>} rolIds
  */
 hipervinculosAdmin(rolIds) {
  return rolIds.has(ROL_ID_ADMINISTRADOR) ?
   /* html */ `<li><a href="indexAdmin.html">Gestionar cuentas</a></li>
   <li><a href="indexEspecialidad.html">Gestionar especialidades</a></li>`
   : ""
 }
 

 /**
  * @param {Set<string>} rolIds
  */
 hipervinculosCliente(rolIds) {
  return rolIds.has(ROL_ID_CLIENTE) ?
   /* html */ `<li><a href="cliente.html">Para clientes</a></li>`
   : ""
 }
}

customElements.define("mi-nav", MiNav)
