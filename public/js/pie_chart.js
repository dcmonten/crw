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


        var options = {
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
    colors: [ '#55AA55','#5555AA', '#AA5555']
}

        var chart = new ApexCharts(
            document.querySelector("#piechart"),
            options
        );

        chart.render()
