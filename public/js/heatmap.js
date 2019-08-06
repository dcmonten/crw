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
      shadeIntensity: 0.5,

      colorScale: {
        ranges: [{
            from: -30,
            to: 5,
            name: 'low',
            color: '#BDECB6'
          },
          {
            from: 6,
            to: 20,
            name: 'medium',
            color: '#86dc79'
          },
          {
            from: 21,
            to: 45,
            name: 'high',
            color: '#66bd59'
          },
          {
            from: 46,
            to: 55,
            name: 'extreme',
            color: '#1b5712'
          }
        ]
      }
    }
  },
  dataLabels: {
    enabled: false
  },
  series: [{
      name: 'Jan',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'Feb',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'Mar',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'Apr',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'May',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'Jun',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'Jul',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'Aug',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    },
    {
      name: 'Sep',
      data: generateData(20, {
        min: -30,
        max: 55
      })
    }
  ],
  title: {
    text: 'HeatMap Chart with Color Range'
  },

}

var chart = new ApexCharts(
  document.querySelector("#heatmap"),
  options
);

chart.render();
