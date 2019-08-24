//Script para que se muestre la última versión del reporte de manera correcta
$("[id^=final]").each(function() {
  var area = document.createElement('textarea');
  var texto = $(this).text();
  $(this).empty();
  $(this).append(texto);
});

//Script para que se muestren los tags correctamente

$(".toHTML").each(function() {
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
  var seccion_numero = $(this).attr('id')[posicion-3];
  var numero_estudiante = $(this).attr('id')[posicion-1];

  var nombre = $('#nombre_'+seccion_numero+"_"+numero_estudiante).text();

  var idEstudiante = nombre.replace(/ /g,'');

  //console.log(idEstudiante+"_"+seccion_numero);

//  $('div#final'+seccion_numero).find("*").toggleClass("highlight");

  //Tomar el tag donde se encuentran los aportes del estudiante
  $('#'+idEstudiante+"_"+seccion_numero).each(function(){
    console.log($(this));
    //Iterar sobre cada uno de sus divs
    $(this).children().each(function(i,frase_html){
      //Sacar la frase dentro del div
      var frase = $.trim(frase_html.innerHTML);

      console.log(frase);

      //Resaltarla con este análisis
      $('div#final'+seccion_numero+'.reportes_finales').find("*").each(function(){
        //console.log($(this));
        if( $(this).is("div") ){
          parrafos = $(this).children();
          console.log(parrafos);
          $.each(parrafos, function(i,linea){
            //console.log(linea.innerText);
            if( linea.innerText.indexOf(frase) > -1 && frase.length > 0){
              console.log(linea);
              console.log(parrafos);
              parrafos.toggleClass("highlight");
            }
          });
        }
        else{
          if( $(this).text().indexOf(frase) > -1 && frase.length > 0){
            $(this).toggleClass("highlight")
          }
        }
      });


    });
  });


});
