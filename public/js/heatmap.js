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


var options = {
  chart: {
    height: 350,
    type: 'heatmap',
  },
  plotOptions: {
    heatmap: {
      enableShades: false,
      colorScale: {
        ranges: [{
            from: 0,
            to: 33,
            name: 'bajo',
            color: '#8B8B8B'
          },
          {
            from: 34,
            to: 66,
            name: 'medio',
            color: '#404040'
          },
          {
            from: 67,
            to: 100,
            name: 'alto',
            color: '#000000'
          }
        ]
      }
    }
  },
  dataLabels: {
    enabled: true
  },
  colors: ["#008FFB"],
  series: [{
      name: 'Jan',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'Feb',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'Mar',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'Apr',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'May',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'Jun',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'Jul',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'Aug',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    },
    {
      name: 'Sep',
      data: generateData(20, {
        min: 0,
        max: 100
      })
    }
  ],
  title: {
    text: 'Frecuencia grupal de aportaciones'
  },

}

var chart = new ApexCharts(
  document.querySelector("#heatmap"),
  options
);

chart.render();
