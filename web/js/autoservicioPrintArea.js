/* 
 * Script para indicar el area de la impresion que se va utilizar en todos los formularios
 * Donde el div se llame showtable
 * Mas info: http://www.jose-aguilar.com/blog/imprimir-zona-de-la-pagina-con-jquery/
 */

$("#imprime").click(function (){
$("div#showTable").printArea();
})
