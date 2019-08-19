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
  var numero = $(this).attr('id')[posicion-1];

  var nombre = $('#nombre'+numero).text();
  var idEstudiante = nombre.replace(/ /g,'');
  var posicionPagina = $('#nombre'+numero).closest('section').attr('id').length;
  var seccion_numero = $('#nombre'+numero).closest('section').attr('id')[posicionPagina-1];

  $('div#final'+seccion_numero+'.reportes_finales').unmark();

  //Tomar el tag donde se encuentran los aportes del estudiante
  $('#'+idEstudiante).each(function(){
    //Iterar sobre cada uno de sus divs
    $(this).children().each(function(i,frase_html){
      //Sacar la frase dentro del div
      var frase = $.trim(frase_html.innerHTML);

      //Resaltarla con este análisis
      $('div#final'+seccion_numero+'.reportes_finales').children().each(function(){
        //Si la frase se encuentra en el texto, quiere decir que PUEDE ser resaltado
        if( ~$(this).text().indexOf(frase) ){
          //Se separa en las frases que ya estén marcadas
          var separacion = $(this).html().split('</mark>');
          //Se va a eliminar las marcadas de la lista, así que se hace una copia para que esta sea la modificada
          var separacion_copia = $(this).html().split('</mark>');
          //Se itera la lista de frases marcadas y no marcadas
          $.each(separacion, function(index,value){
            //Si se encuentra un elemento que sí está marcado
            if( value.indexOf('<mark data-markjs="true">') > -1 ){
              //Se halla su índice en el arreglo copia
              var indice = separacion_copia.indexOf(value);
              //Y se lo remueve
              separacion_copia.splice(indice,1);
            }
          });

          //console.log(separacion_copia);

          /*Si la palabra que quiere ser resaltada todavía se encuentra en el arreglo copiado,
          quiere decir que no ha sido resaltada todavía, así que se resalta*/
          if( $.inArray(frase,separacion_copia) ){
            $(this).mark(frase);
            //La siguiente línea es ara que no se resalte más de 1 palabra igual en el documento
            //return false;
          }
        }
      });


    });
  });


  /*
  $.each(array, function(i,texto){

  });



  $('div#final'+seccion_numero+'.reportes_finales').children().each(function(){
    if( ~$(this).text().indexOf(textoPrueba2)
        &&
        $(this).html().split('<mark data-markjs="true">').length == 1
      ){
      $(this).mark(textoPrueba2);
      return false;
    }
  });*/

});
