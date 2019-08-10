/* globals Chart:false, feather:false */

(function () {
  'use strict'

  feather.replace();

  $("#btn-sidebar").click( function(){

    $("#sidebar").toggleClass("collapse");
    $("main").toggleClass("col-md-9 col-lg-10 w-100");

  }
  );

}())
