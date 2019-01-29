<?php

$dataPoints = array();
$y = 20;
for($i = 0; $i < 10; $i++){
	$y += rand(-1, 1) * 0.1; 
	array_push($dataPoints, array("x" => $i, "y" => $y));
}
 
?>

<script>
window.onload = function() {
 
var dataPoints = <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>;
 
var chart1 = new CanvasJS.Chart("chartContainer1", {
	theme: "light2",
	title: {
		text: "Temperature in <?php echo ucwords(strtolower($nummer[0])); ?>"
	},
	axisX:{
		title: "Time in Seconds"
	},
	axisY:{
		includeZero: false,
		suffix: " Degrees celcius"
	},
	data: [{
		type: "line",
		yValueFormatString: "#,##0.0#",
		toolTipContent: "{y} Degrees celcius",
		dataPoints: dataPoints
	}]
});
chart.render();
 
var updateInterval = 1500;
setInterval(function () { updateChart() }, updateInterval);
 
var xValue = dataPoints.length;
var yValue = dataPoints[dataPoints.length - 1].y;
 
function updateChart1() {
	yValue += (Math.random() - 0.5) * 0.1;
	dataPoints.push({ x: xValue, y: yValue });
	xValue++;
	chart.render();
};
 
}