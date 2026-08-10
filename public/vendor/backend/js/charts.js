(function($) {
    "use strict";

    let dashboardUsersChart = $('#dashboard-users-chart');
    if (dashboardUsersChart.length) {
        window.Chart && new Chart(dashboardUsersChart, {
            type: 'line',
            data: {
                labels: chartsConfig.users.labels,
                datasets: [{
                    label: chartsConfig.users.title,
                    data: chartsConfig.users.data,
                    fill: false,
                    pointBackgroundColor: config.colors.primary_color,
                    borderColor: config.colors.primary_color,
                    borderWidth: 2,
                    lineTension: .10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        suggestedMax: chartsConfig.users.max,
                    }
                }
            }
        });
    }

    let dashboardUploadsCharts = $('#dashboard-uploads-chart');
    if (dashboardUploadsCharts.length) {
        window.Chart && new Chart(dashboardUploadsCharts, {
            type: 'bar',
            data: {
                labels: chartsConfig.uploads.labels,
                datasets: [{
                    label: chartsConfig.uploads.title,
                    data: chartsConfig.uploads.data,
                    fill: false,
                    backgroundColor: config.colors.secondary_color,
                    borderColor: config.colors.secondary_color,
                    borderWidth: 2,
                    lineTension: .10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: {
                    y: {
                        suggestedMax: chartsConfig.uploads.max,
                    }
                }
            }
        });
    }

    let dashboardBrowsersChart = $('#dashboard-browsers-chart');
    if (dashboardBrowsersChart.length) {
        window.Chart && new Chart(dashboardBrowsersChart, {
            type: 'doughnut',
            data: {
                labels: chartsConfig.logs.browsers.labels,
                datasets: [{
                    data: chartsConfig.logs.browsers.data,
                    backgroundColor: [
                        "#263bd8",
                        "#91628d",
                        "#d4aaf1",
                        "#aab045",
                        "#71cccd",
                        "#de388a",
                        "#a7935b",
                        "#5fb2fb",
                        "#fabb01",
                        "#51ab1c",
                        "#728251",
                        "#709e14",
                        "#2e4007",
                        "#a57837",
                        "#8f1672",
                        "#a76bd1",
                        "#5b6d38",
                        "#7cb7aa",
                        "#a140b7",
                        "#17855c",
                        "#4bb7ce",
                        "#a688b0",
                        "#5351b7",
                        "#569cfa",
                        "#8ca2d1",
                    ],
                    borderColor: [
                        '#e7505abf'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
            }
        });
    }


    let dashboardOsChart = $('#dashboard-os-chart');
    if (dashboardOsChart.length) {
        window.Chart && new Chart(dashboardOsChart, {
            type: 'doughnut',
            data: {
                labels: chartsConfig.logs.os.labels,
                datasets: [{
                    data: chartsConfig.logs.os.data,
                    backgroundColor: [
                        "#52ebad",
                        "#f75345",
                        "#9b5aed",
                        "#9a3cb",
                        "#51a62d",
                        "#af3ca2",
                        "#fab325",
                        "#39a474",
                        "#95c55e",
                        "#38d692",
                        "#e46126",
                        "#f68f56",
                        "#62c4df",
                        "#fbcd37",
                        "#33edba",
                        "#bbb4b8",
                        "#af6189",
                        "#21bdb",
                        "#1e106a",
                        "#817221",
                        "#431c09",
                        "#91c508",
                        "#355b62",
                        "#697079",
                        "#de3ae4",
                    ],
                    borderColor: [
                        '#e7505abf'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
            }
        });
    }

    let dashboardCountriesChart = $('#dashboard-countries-chart');
    if (dashboardCountriesChart.length) {
        window.Chart && new Chart(dashboardCountriesChart, {
            type: 'doughnut',
            data: {
                labels: chartsConfig.logs.countries.labels,
                datasets: [{
                    data: chartsConfig.logs.countries.data,
                    backgroundColor: [
                        "#2ccf1b",
                        "#42ea",
                        "#6e1dc4",
                        "#bf1f98",
                        "#f5ffb2",
                        "#4bfce4",
                        "#bb9416",
                        "#460716",
                        "#3fc812",
                        "#86b104",
                        "#c5fe39",
                        "#29e230",
                        "#66b8dc",
                        "#9f5927",
                        "#28702c",
                        "#abe28c",
                        "#9fc9ef",
                        "#d50909",
                        "#aecc6f",
                        "#39540c",
                        "#bc9623",
                        "#d93b8b",
                        "#b907d1",
                        "#436948",
                        "#9ea635",
                    ],
                    borderColor: [
                        '#e7505abf'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
            }
        });
    }


    let earningsStatisticsChart = $('#earnings-statistics-chart')
    if (earningsStatisticsChart.length) {
        window.Chart && new Chart(earningsStatisticsChart, {
            type: 'line',
            data: {
                labels: chartsConfig.earnings.labels,
                datasets: [{
                    label: chartsConfig.earnings.title,
                    data: chartsConfig.earnings.data,
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
                    },
                    y: {
                        suggestedMax: chartsConfig.earnings.max,
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
        google.charts.load('current', {
            'packages': ['geochart']
        });
        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = google.visualization.arrayToDataTable(geoChartConfig);
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