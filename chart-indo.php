<?php
    require 'statistik-corona.php';
?>
<!doctype html>
<html>

<head>
	<title>Line Chart</title>
	<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js?v=<?=date('His')?>"></script>
	<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
	<style>
	canvas{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
</head>

<body>
	<div style="width:75%;">
		<canvas id="canvas"></canvas>
	</div>
	<script>
        var tanggal = [];
        fetch('statistik-corona.php?tipe=tanggal')
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            // dataJson = data;
           for(var i = 0; i < data.length; i++){
                tanggal.push(data[i]);
           }
        });
        console.log(tanggal);
		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var config = {
			type: 'line',
			data: {
				labels: <?= sortir($data,'tgl') ?>,
				datasets: [{
					label: 'Positif',
					fill: false,
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: <?= sortir($data,'positif') ?>,
                },
                {
					label: 'Dirawat',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: <?= sortir($data,'rawat') ?>,
				},
                {
					label: 'Sembuh',
					backgroundColor: window.chartColors.green,
					borderColor: window.chartColors.green,
					data: <?= sortir($data,'sembuh') ?>,
					fill: false,
				},
                {
					label: 'Meninggal',
					fill: false,
					backgroundColor: window.chartColors.yellow,
					borderColor: window.chartColors.yellow,
					data: <?= sortir($data,'meninggal') ?>,
                }]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Grafik Kasus Covid-19'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Tanggal'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};
	</script>
</body>

</html>
