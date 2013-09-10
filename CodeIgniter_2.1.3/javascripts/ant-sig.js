

//codigo necesario para el funcionamiento de la barra de "anterior - siguiente"
$(document).ready(function () {
$('.inicio').each(function () {
string = "<div class='elemento_navegacion activo'>"+ $(this).attr("titulo") +"</div>";
});
$('.bloque , .final').each(function () {
string = string + "<div class='elemento_navegacion'>"+ $(this).attr("titulo") +"</div>";
});
$(".contenedor_ant_sig div.inicio").each(function (index) {
$(this).append("<div class='box_anterior_siguiente'><div class='barra_navegacion'>"+ string +"</div><button class='siguiente'>siguiente</button></div>");
$(this).addClass("activo");
});
$(".contenedor_ant_sig .bloque").each(function (index) {
$(this).append("<div class='box_anterior_siguiente'><div class='barra_navegacion'>"+string+"</div><button class='siguiente'>siguiente</button><button class='anterior'>anterior</button></div>");
});
$(".contenedor_ant_sig .final").each(function (index) {
var submit_name = "Enviar";
if( $(".contenedor_ant_sig").attr('boton_enviar') ){
submit_name = $(".contenedor_ant_sig").attr('boton_enviar');
}
//el submit puede o no tener mas atributos los cuales deben ser especificados caso a caso.
$(this).append("<div class='box_anterior_siguiente'><div class='barra_navegacion'>"+string+"</div><input class='submit' type='submit' value='"+ submit_name +"' /><button class='anterior'>anterior</button></div>");
});
$('.contenedor_ant_sig div button.siguiente').click(function(event){
event.preventDefault();
event.stopPropagation();
$(".activo").removeClass("activo").next().addClass("activo");
});
$('.contenedor_ant_sig div button.anterior').click(function(event){
event.preventDefault();
event.stopPropagation();
$(".activo").removeClass("activo").prev().addClass("activo");
});
$('.contenedor_ant_sig').height(altura_maxima_bloques);
var cantidad_cartas = $(".inicio .elemento_navegacion").length;
var ancho_total = $(".barra_navegacion").width();
var ancho_elemento_navegacion = Math.floor(ancho_total/cantidad_cartas - 5);
$(".elemento_navegacion").css({width:ancho_elemento_navegacion});
var altura_maxima_bloques=$(".contenedor_ant_sig div.inicio").height();
$('.contenedor_ant_sig div.inicio, .contenedor_ant_sig div.bloque,.contenedor_ant_sig div.final').each(function () {
if( altura_maxima_bloques < $(this).height() ){
altura_maxima_bloques = $(this).height();
}
});
$('.contenedor_ant_sig div.inicio, .contenedor_ant_sig div.bloque,.contenedor_ant_sig div.final').each(function () {
$(this).height(altura_maxima_bloques+40);
});
});