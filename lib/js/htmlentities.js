/**
 * Codifica un texto para que cambie los caracteres
 * especiales y no se pueda interpretar como
 * etiiqueta HTML. Esta técnica evita la inyección
 * de código.
 * @param { string } texto
*/
export function htmlentities(texto) {
 return texto.replace(/[<>"']/g, textoDetectado => {
  switch (textoDetectado) {
   case "<": return "&lt;"
   case ">": return "&gt;"
   case '"': return "&quot;"
   case "'": return "&#039;"
   default: return textoDetectado
  }
 })
}
