function getData(){

  var map= [];
  var added = [];
  var deleted = [];
  var imadded = [];
  var imdeleted = [];
  var mad =[];

  $('[id^=estudiante').each(function(index){

    estudiante=new Object();
    estudiante.nombre=String($('[id^=nom]',this).text());
    estudiante.pal_ag=parseInt($('[id^=pal_mas]',this).text());
    estudiante.pal_menos=parseInt($('[id^=pal_menos]',this).text());

    map.push(estudiante.nombre);
    added.push(estudiante.pal_ag);
    deleted.push(estudiante.pal_menos);
    imadded.push(parseInt($('[id^=im_mas]',this).text()));
    imdeleted.push(parseInt($('[id^=im_menos]',this).text()));

    });

  mad.push(map,added,deleted,imadded,imdeleted);


  return mad;

}

  var data=getData();
  var category_list = data[0];
  var added_list = data[1];
  var deleted_list = data[2];
  var im_add_list = data [3];
  var im_del_list = data [4];

  var add = {
          chart: {
              width: 750,
              type: 'pie',
          },
          labels:  category_list,
          series: added_list,
          responsive: [{
              breakpoint: 480,
              options: {
                  chart: {
                      width: 200
                  },
                  legend: {
                      position: 'bottom'
                  }
              }
          }],
    title: {
    text: 'Palabras añadidas',
    style: {
      fontSize: '24px'
    }
    },
    colors: [ '#e6261f','#eb7532', '#a3e048','#49da9a','#34bbe6']
    }


    var del = {
              chart: {
                  width: 750,
                  type: 'pie',
              },
              labels:  category_list,
              series: deleted_list,
              responsive: [{
                  breakpoint: 480,
                  options: {
                      chart: {
                          width: 200
                      },
                      legend: {
                          position: 'bottom'
                      }
                  }
              }],
        title: {
        text: 'Palabras corregidas',
        style: {
          fontSize: '24px'
        }
        },
        colors: [ '#e6261f','#eb7532', '#a3e048','#49da9a','#34bbe6']
        }


        var imadd = {
                  chart: {
                      width: 750,
                      type: 'pie',
                  },
                  labels:  category_list,
                  series: im_add_list,
                  responsive: [{
                      breakpoint: 480,
                      options: {
                          chart: {
                              width: 200
                          },
                          legend: {
                              position: 'bottom'
                          }
                      }
                  }],
            title: {
            text: 'Imágenes añadidas',
            style: {
              fontSize: '24px'
            }
            },
            colors: [ '#e6261f','#eb7532', '#a3e048','#49da9a','#34bbe6']
            }


            var imdel = {
                      chart: {
                          width: 750,
                          type: 'pie',
                      },
                      labels:  category_list,
                      series: im_del_list,
                      responsive: [{
                          breakpoint: 480,
                          options: {
                              chart: {
                                  width: 200
                              },
                              legend: {
                                  position: 'bottom'
                              }
                          }
                      }],
                title: {
                text: 'Imágenes corregidas',
                style: {
                  fontSize: '24px'
                }
                },
                colors: [ '#e6261f','#eb7532', '#a3e048','#49da9a','#34bbe6']
                }

        var pie_wp = new ApexCharts(
            document.querySelector("#pie"),
            add
        );
        pie_wp.render();

        var pie_dw = new ApexCharts(
            document.querySelector("#pie"),
            del
        );

        var pie_ia = new ApexCharts(
            document.querySelector("#pie"),
            imadd
        );


        var pie_id = new ApexCharts(
            document.querySelector("#pie"),
            imdel
        );

        $( "#btn_1" ).click(function() {
          $("#pie").empty();
          pie_wp.render();

        });
        $( "#btn_2" ).click(function() {
          $("#pie").empty();
          pie_dw.render();

        });
        $( "#btn_3" ).click(function() {
          $("#pie").empty();
          pie_ia.render();

        });
        $( "#btn_4" ).click(function() {
          $("#pie").empty();
          pie_id.render();

        });
