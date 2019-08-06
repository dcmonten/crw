
        var options = {
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            series: [44, 55, 13, 43, 22],
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
	    text: 'PIE'
	  },
        }

        var chart = new ApexCharts(
            document.querySelector("#piechart"),
            options
        );

        chart.render()
