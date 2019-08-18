//Script para que se muestre la última versión del reporte de manera correcta
$("[id^=final]").each(function() {
  var area = document.createElement('textarea');
  var texto = $(this).text();
  $(this).empty();
  $(this).append(texto);
});

/*Para las siguientes funciones:
pagina0, pagina1, pagina2, ... abarca el contenido de la página en su versión final
aporte0, aporte1, aporte2 ... abarca la sección que contiene los aportes individuales
*/
//Script para que se muestre sólo la página seleccionada
$("[id^=titulo]").click(function(){
  var titulo = $(this).attr('id');
  var posicion = $(this).attr('id').length;
  var numero = $(this).attr('id')[posicion-1];
  $("[id^=pagina]").each(function(){
    var paginaNum = $(this).attr('id')[$(this).attr('id').length-1];
    if(numero != paginaNum){
      $(this).hide();
      $("#aporte"+paginaNum).hide();
    }
    else{
      $(this).show();
      $("#aporte"+paginaNum).show();
    }
  });
});

//imgfluid y table-responsive
$("table").addClass("table-responsive w-100");
$("img").addClass("img-fluid");


//Función que cuando carga el documento, sólo muestra el primer reporte
$(document).ready(function() {
  $("[id^=pagina]").each(function() {
    var i = $(this).attr('id').length;
    var num = $(this).attr('id')[i-1];
    //console.log(num);
    if($(this).attr('id') == 'pagina0'){
      $(this).show();
      $("#aporte"+num).show();
    }
    else{
      $(this).hide();
      $("#aporte"+num).hide();
    }
  });
});


//Función para el resaltado de los aportes
$("[id^=resaltar]").click(function(){
  var titulo = $(this).attr('id');
  var posicion = $(this).attr('id').length;
  var numero = $(this).attr('id')[posicion-1];

  var nombre = $('#nombre'+numero).text();
  var posicionPagina = $('#nombre'+numero).closest('section').attr('id').length;
  var seccion_numero = $('#nombre'+numero).closest('section').attr('id')[posicionPagina-1];

  var textoPrueba = "Perfil Persona:";
  var textoPrueba2 = "Estudiantes de la materia de Emprendimiento y ARP que utilizan páginas wiki para trabajos en grupo";

  $('div#final'+seccion_numero+'.reportes_finales').children().each(function(){
    if( ~$(this).text().indexOf(textoPrueba)
        &&
        $(this).html().split('<mark data-markjs="true">').length == 1
      ){
      $(this).mark(textoPrueba);
      console.log( $(this).html().split('<mark data-markjs="true">').join('').split('</mark>') );
      return false;
    }
  });

  $('div#final'+seccion_numero+'.reportes_finales').children().each(function(){
    if( ~$(this).text().indexOf(textoPrueba2)
        &&
        $(this).html().split('<mark data-markjs="true">').length == 1
      ){
      $(this).mark(textoPrueba2);
      return false;
    }
  });

});
