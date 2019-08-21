function getData(){

  var map= [];
  var added = [];
  var deleted = [];
  var adim=[];
  var delim = [];
  var mad =[];

  $('[id^=estudiante').each(function(index){

    estudiante=new Object();
    estudiante.nombre=String($('[id^=nom]',this).text());
    estudiante.pal_ag=parseInt($('[id^=pal_mas]',this).text());
    estudiante.pal_menos=parseInt($('[id^=pal_menos]',this).text());

    map.push(estudiante.nombre);
    added.push(estudiante.pal_ag);
    deleted.push(estudiante.pal_menos);
    adim.push(parseInt($('[id^=im_mas]',this).text()));
    delim.push(parseInt($('[id^=im_menos]',this).text()));
    });

  mad.push(map,added,deleted, adim, delim);


  return mad;

}


        var data=getData();

        var category_list = data[0];
        var added_list = data[1];
        var deleted_list = data[2];
        var adim = data[3];
        var delim = data[4];

        var options = {
            chart: {
                height: 350,
                type: 'bar',
                stacked: true,
                stackType: '100%'
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                },

            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            series: [{
                name: 'Palabras añadidas',
                data: added_list
            },{
                name: 'Palabras corregidas',
                data: deleted_list
            },{
                name: 'Imagenes agregadas',
                data: adim
            },{
                name: 'Imagenes corregidas',
                data: delim
            }],
            title: {
                text: 'Contribuciones en porcentajes'
            },
            xaxis: {
                categories: category_list,
            },
            tooltip: {
                    y: {
                        formatter: function(val) {
                        return val
                    }
                }
            },
            fill: {
                opacity: 1,
            },

            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40,
            },

            colors: [ '#25AA25','#88AA88','#008888','#005050']
        }

       var chart = new ApexCharts(
            document.querySelector("#barchart"),
            options
        );

        chart.render();
