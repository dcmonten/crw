//Script para que se muestre la última versión del reporte de manera correcta
$("[id^=final]").each(function() {
  var area = document.createElement('textarea');
  var texto = $(this).text();
  $(this).empty();
  $(this).append(texto);
});
