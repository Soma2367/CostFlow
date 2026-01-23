import ApexCharts from 'apexcharts';

export function subScriptionChart() {
    const chartId = document.getElementById('subScriptionChart');

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
        theme: {
            palette: 'palette2'
        },
        labels: labels,
        responsive: [{
            breakpoint: 480,
            options: {
            chart: {
                width: 500
            },
            legend: {
                position: 'bottom'
            }
            }
        }]
        };

        var chart = new ApexCharts(document.getElementById("subScriptionChart"), options);
            chart.render();
};
