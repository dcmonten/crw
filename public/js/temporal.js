
/* Se toma el último elemento de la tabla recorriendo los tags: tbody->tr->td, y a eso se le saca el texto puro con tags y todo -->*/
  var texto_con_tags = $('#final').text();

/*  <!-- Aquí creé un área de texto para meter todo el HTML del reporte -->*/
  var area = document.createElement('textarea');

/*  <!-- Y entonces a eso le meto el HTML -->*/
  area.innerHTML = texto_con_tags;

/*  <!-- Tomo el tag <section> y le agrego un título junto con el área de texto que ahora tiene el HTML -->*/
  var section = $('#final');

  section.empty();
  
  section.append(area.value);
