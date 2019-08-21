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

  var series = [jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,dic];

  $('[id^=date').each(
    function(index)
    {
      var date = $(this).text();
      var dmy = date.split("/");
      var mes= parseInt(dmy[1]);
      var dia = parseInt(dmy[0]);
      series[mes-1][dia]=qts[index];
    }
  );
  console.log(series);
  return series;
}

function objectSeries(series)
{
  objser =[];
  for (i = 0; i<12;i++)
  {
    var temp=[];
    for (j=0;j<31;j++){
      temp.push({x:j+1,y:series[i][j]});
    }
    objser.push(temp);
  }

  return objser;

}


var month_string = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var quantities=JSON.parse($('#qts_array').text());
console.log(quantities);
var min=parseInt($('#min_val').text());
console.log(min);
var max=parseInt($('#max_val').text());
console.log(max);
var quantiles= math.quantileSeq(quantities, [1/3, 2/3]);

var months = objectSeries(series(quantities));




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
            from: math.ceil(quantiles[0])+1,
            to: math.floor(quantiles[1]),
            name: 'Contribuciones Intermedias',
            color: '#55AA55'
          },
          {
            from: math.ceil(quantiles[1])+1,
            to: max+1,
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
  series: [{
      name: month_string[11],
      data: months[11]
    },
    {
      name: month_string[10],
      data: months[10]
    },
    {
      name: month_string[9],
      data: months[9]
    },
    {
      name: month_string[8],
      data: months[8]
    },
    {
      name: month_string[7],
      data: months[7]
    },
    {
      name: month_string[6],
      data: months[6]
    },
    {
      name: month_string[5],
      data: months[5]
    },
    {
      name: month_string[4],
      data: months[4]
    },
    {
      name: month_string[3],
      data: months[3]
    },
    {
      name: month_string[2],
      data: months[2]
    },
    {
      name: month_string[1],
      data: months[1]
    },
    {
      name: month_string[0],
      data: months[0]
    }
  ]

}

var chart = new ApexCharts(
  document.querySelector("#heatmap"),
  options
);

chart.render();
