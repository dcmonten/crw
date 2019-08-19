function getData(){

  var map= [];
  var added = [];
  var deleted = [];
  var mad =[];

  $('[id^=estudiante').each(function(index){

    estudiante=new Object();
    estudiante.nombre=String($('[id^=nom]',this).text());
    estudiante.pal_ag=parseInt($('[id^=pal_mas]',this).text());
    estudiante.pal_menos=parseInt($('[id^=pal_menos]',this).text());

    map.push(estudiante.nombre);
    added.push(estudiante.pal_ag);
    deleted.push(estudiante.pal_menos);


    });

  mad.push(map,added,deleted);


  return mad;

}


        var data=getData();

        var category_list = data[0];
        var added_list = data[1];
        var deleted_list = data[2];

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
            }],
            title: {
                text: 'Palabras en porcentajes'
            },
            xaxis: {
                categories: category_list,
            },
            tooltip: {
                    y: {
                        formatter: function(val) {
                        return val + " palabras"
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

            colors: [ '#25AA25','#88AA88']
        }

       var chart = new ApexCharts(
            document.querySelector("#barchart"),
            options
        );

        chart.render();
