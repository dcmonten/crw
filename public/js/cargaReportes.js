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

//Función que cuando carga el documento, sólo muestra el primer reporte
$(document).ready(function() {
  $("[id^=pagina]").each(function() {
    var i = $(this).attr('id').length;
    var num = $(this).attr('id')[i-1];
    console.log(num);
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
