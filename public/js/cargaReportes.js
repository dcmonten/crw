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
  //Para que los botones cambien de color y avisen quién está resaltado
  $(this).toggleClass("btn-success");
  $(this).toggleClass("btn-warning");

  //Para sacar los ids correspondientes
  var titulo = $(this).attr('id');
  var posicion = $(this).attr('id').length;
  var seccion_numero = $(this).attr('id')[posicion-3];
  var numero_estudiante = $(this).attr('id')[posicion-1];

  var nombre = $('#nombre_'+seccion_numero+"_"+numero_estudiante).text();

  var idEstudiante = nombre.replace(/ /g,'');

  //Tomar el tag donde se encuentran los aportes del estudiante
  $('#'+idEstudiante+"_"+seccion_numero).each(function(){
    //Iterar sobre cada uno de sus divs
    $(this).children().each(function(i,frase_html){
      //Sacar la frase dentro del div
      var frase = $.trim(frase_html.innerHTML);

      //console.log("Frase: "+frase);

      //Resaltarla con este análisis
      $('div#final'+seccion_numero+'.reportes_finales').find("*").each(function(){
        //console.log($(this));
          //console.log($(this).children());
          if($(this).children().length > 0){
            $(this).find("*").each(function(){
              //console.log($(this).text());
              //console.log("---------------------------------");
              if( $(this).text() === frase || $(this).html() === frase ){
                //console.log($(this));
                $(this).toggleClass('highlight');

              }
            });
          }
          else{
            //console.log($(this));
            //console.log("---------------------------------");
            if( $(this).text() === frase || $(this).html() === frase ){
              //console.log($(this));
              $(this).toggleClass('highlight');

            }
          }
      });
    });
  });
});
