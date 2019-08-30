function generateData(count, yrange) {
  var i = 0;
  var series = [];
  while (i < count) {
    var x = (i + 1).toString();
    var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

    series.push({
      x: x,
      y: y
    });
    i++;
  }
  return series;
}

//x es el dia, y es la cantidad
function series(qts){

  var month_string = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  var jan=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var feb=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var mar=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var apr=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var may=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var jun=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var jul=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var aug=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var sep=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var oct=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var nov=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
  var dic=[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

  var series = [{name: month_string[0], data: jan},
                {name: month_string[1], data: feb},
                {name: month_string[2], data: mar},
                {name: month_string[3], data: apr},
                {name: month_string[4], data: may},
                {name: month_string[5], data: jun},
                {name: month_string[6], data: jul},
                {name: month_string[7], data: aug},
                {name: month_string[8], data: sep},
                {name: month_string[9], data: oct},
                {name: month_string[10], data: nov},
                {name: month_string[11], data: dic}
];
//,mar,apr,may,jun,jul,aug,sep,oct,nov,dic
  var series_real = [];

var months=[];
  $('[id^=date').each(
    function(index)
    {
      var date = $(this).text();
      var dmy = date.split("/");
      var mes= parseInt(dmy[1]);
      var dia = parseInt(dmy[0]);
      series[mes-1].data[dia]=qts[index];
      months.push(mes-1);
    }
  );
  //console.log(months);
  var uniqueMonths = [];
  $.each(months, function(i, el){
    if($.inArray(el, uniqueMonths) === -1) uniqueMonths.push(el);
  });
  //console.log(uniqueMonths);

  $.each(uniqueMonths, function(i, el){
    series_real.push(series[el]);
  });


  //console.log(series_real);


  return series_real;
}



var quantities=JSON.parse($('#qts_array').text());
//console.log(quantities);
var min=parseInt($('#min_val').text());
//console.log(min);
var max=parseInt($('#max_val').text());
//console.log(max);
var quantiles= math.quantileSeq(quantities, [1/3, 2/3]);

var data = series(quantities);




var options = {
  chart: {
    height: 500,
    type: 'heatmap',
  },
  plotOptions: {
    heatmap: {
      enableShades: false,
      colorScale: {
        ranges: [{
            from: 0,
            to: 0,
            name: 'Ninguna contribucion',
            color: '#EEEEEE'
          },{
            from: 1,
            to: math.floor(quantiles[0]),
            name: 'Pocas contribuciones',
            color: '#AA9999'
          },
          {
            from: math.ceil(quantiles[0]),
            to: math.floor(quantiles[1]),
            name: 'Contribuciones Intermedias',
            color: '#55AA55'
          },
          {
            from: math.ceil(quantiles[1]),
            to: max,
            name: 'Muchas contribuciones',
            color: '#0000AA'
          }
        ]
      }
    }
  },
  dataLabels: {
    enabled: true,
    formatter:  function(value, { seriesIndex, dataPointIndex, w }) {
                if (value==0) return '';
                else return value;
  }
  },
  colors: ["#008FFB"],
  series: data.reverse(),
  tooltip: {
          y: {
              formatter: function(val) {
              if(val>1 || val==0)return val + " contribuciones";
              else return val +" contribución"
          }
      }
  },

}

var chart = new ApexCharts(
  document.querySelector("#heatmap"),
  options
);

chart.render();
