import ApexCharts from "apexcharts";

export function adminChart() {
    const chartId = document.getElementById('adminChart');

    const seriesDataSet = chartId.dataset.series;
    const labelsDataSet = chartId.dataset.labels;

    const series = JSON.parse(seriesDataSet);
    const labels = JSON.parse(labelsDataSet);

    var options = {
        series: series,
        chart: {
            width: 500,
            type: 'pie',
        },
        labels: labels,
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                const amount = opts.w.config.series[opts.seriesIndex];
                return '¥' + amount.toLocaleString();
            },
        },
        legend: {
            formatter: function (seriesName, opts) {
                const amount = opts.w.config.series[opts.seriesIndex];
                return seriesName + ' - ¥' + amount.toLocaleString();
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return '¥' + val.toLocaleString();
                }
            }
        },
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
        }]
    };

    var chart = new ApexCharts(document.getElementById('adminChart'), options);
    chart.render();
}
