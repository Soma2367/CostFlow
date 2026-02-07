import ApexCharts from "apexcharts";

export function adminChart() {
    const chartId = document.getElementById("adminChart");

    const seriesDataSet = chartId.dataset.series;
    const labelsDataSet = chartId.dataset.labels;

    try {
        const series = JSON.parse(seriesDataSet);
        const labels = JSON.parse(labelsDataSet);

        var options = {
            series: series,
            chart: {
                width: "100%",
                type: "pie",
            },
            plotOptions: {
                pie: {
                    customScale: 0.7,
                },
            },
            labels: labels,
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    const amount = opts.w.config.series[opts.seriesIndex];
                    return "¥" + amount.toLocaleString();
                },
            },
            legend: {
                formatter: function (seriesName, opts) {
                    const amount = opts.w.config.series[opts.seriesIndex];
                    return seriesName + " - ¥" + amount.toLocaleString();
                },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "¥" + val.toLocaleString();
                    },
                },
            },
            responsive: [
                {
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: "100%",
                        },
                        legend: {
                            position: "bottom",
                            maxHeight: 80,
                        },
                    },
                },
            ],
        };
        var chart = new ApexCharts(
            document.getElementById("adminChart"),
            options,
        );
        chart.render();
    } catch (e) {
        console.log("adminChart: parse error", e);
        chartId.innerHTML =
            '<p class="text-gray-400 italic">データの読み込みに失敗しました</p>';
        return;
    }
}
