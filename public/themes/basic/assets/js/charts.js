(function($) {
    "use strict";
    let statisticsChart = document.getElementById('statistics-chart');
    if (statisticsChart) {
        window.Chart && new Chart(statisticsChart, {
            type: 'line',
            data: {
                labels: chartConfig.line.labels,
                datasets: [{
                    label: chartConfig.line.title,
                    data: chartConfig.line.data,
                    fill: false,
                    pointBackgroundColor: config.colors.primary_color,
                    borderWidth: 2,
                    borderColor: config.colors.primary_color,
                    lineTension: .10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 17
                        }
                    },
                    y: {
                        suggestedMax: chartConfig.line.max,
                        grid: {
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }

    let countriesDownloadsStatistics = document.getElementById('countries-downloads-statistics');
    if (countriesDownloadsStatistics) {
        google.charts.load('current', { 'packages': ['geochart'] });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable(chartConfig.geo.data);
            var options = {
                colorAxis: {
                    colors: [
                        config.colors.primary_color
                    ]
                },
            };
            var geoChart = new google.visualization.GeoChart(countriesDownloadsStatistics);
            geoChart.draw(data, options);
        }
    }

})(jQuery);