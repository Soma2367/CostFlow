import ApexCharts from 'apexcharts';

export function fixedCostChart() {
    const chartId = document.getElementById('fixedCostChart');

    const seriesDataSet = chartId.dataset.series;
    const labelsDataSet = chartId.dataset.labels;

    const series = JSON.parse(seriesDataSet);
    const labels = JSON.parse(labelsDataSet);
    console.log(series, labels);

    var options = {
    series: series,
    chart: {
    width: 380,
    type: 'pie',
    },
    labels: labels,
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

    var chart = new ApexCharts(document.querySelector("#fixedCostChart"), options);
        chart.render();
}
