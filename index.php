<?php
  // require 'data-corona.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <!-- <meta charset="UTF-8" /> -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Corona Data Di Indonesia</title>
    <link rel="stylesheet" href="index.css" />
  </head>
  <body>
    <div id="chartdiv"></div>
    <script src="http://amcharts.com/lib/4/core.js"></script>
<script src="http://amcharts.com/lib/4/charts.js"></script>
<script src="http://amcharts.com/lib/4/maps.js"></script>
    <script src="http://amcharts.com/lib/4/themes/animated.js"></script>
    <script src="http://amcharts.com/lib/4/geodata/worldLow.js"></script>
    <script src="http://amcharts.com/lib/4/geodata/indonesiaLow.js"></script>
    <!-- <script src="index.js"></script> -->
    <script>
      /**
 * ---------------------------------------
 * This demo was created using amCharts 4.
 *
 * For more information visit:
 * https://www.amcharts.com/
 *
 * Documentation is available at:
 * https://www.amcharts.com/docs/v4/
 * ---------------------------------------
 */

// Create map instance
var chart = am4core.create("chartdiv", am4maps.MapChart);

chart.zoomControl = new am4maps.ZoomControl();
chart.zoomControl.slider.height = 150;
// Set map definition
chart.geodata = am4geodata_indonesiaLow ;
// Set projection
// chart.projection = new am4maps.projections.Miller();
chart.projection = new am4maps.projections.Mercator();

// Create map polygon series
var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

var dataJson;

<<<<<<< HEAD
fetch('./data-corona.php')
=======
fetch('data-corona.php')
>>>>>>> ae893f253becbd07a9ff770b3bd4bc2423d4f0f6
  .then((response) => {
    return response.json();
  })
  .then((data) => {
    // dataJson = data;
    polygonSeries.data = data;
  });

//Set min/max fill color for each area
polygonSeries.heatRules.push({
    property: "fill",
    target: polygonSeries.mapPolygons.template,
    min: am4core.color("#F2D4D4"),
    max: am4core.color("#BF2100")
  });

polygonSeries.exclude = ["MY-13","TL","BN","MY-12"];


// Make map load polygon (like country names) data from GeoJSON
polygonSeries.useGeodata = true;

  let heatLegend = chart.createChild(am4maps.HeatLegend);
  heatLegend.series = polygonSeries;
  heatLegend.align = "right";
  heatLegend.width = am4core.percent(25);
  heatLegend.marginRight = am4core.percent(4);
  heatLegend.minValue = 0;
  heatLegend.maxValue = 40000000;
  heatLegend.valign = "bottom";

  // Set up custom heat map legend labels using axis ranges
  var minRange = heatLegend.valueAxis.axisRanges.create();
  minRange.value = heatLegend.minValue;
  minRange.label.text = "Rendah";
  var maxRange = heatLegend.valueAxis.axisRanges.create();
  maxRange.value = heatLegend.maxValue;
  maxRange.label.text = "Tinggi";

  // Blank out internal heat legend value axis labels
  heatLegend.valueAxis.renderer.labels.template.adapter.add("text", function(labelText) {
    return "";
  });




// Configure series
var polygonTemplate = polygonSeries.mapPolygons.template;


polygonTemplate.tooltipHTML = `<center><strong>Provinsi {name}</strong></center>
<hr />
<table>
<tr>
  <th align="left">Positif</th>
  <td>:</td>
  <td>{positif}</td>
</tr>
<tr>
  <th align="left">Sembuh</th>
  <td>:</td>
  <td>{sembuh}</td>
</tr>
<tr>
  <th align="left">Rawat</th>
  <td>:</td>
  <td>{rawat}</td>
</tr>
<tr>
  <th align="left">Meninggal</th>
  <td>:</td>
  <td>{meninggal}</td>
</tr>
</table>
<hr />`;
polygonTemplate.nonScalingStroke = true;
  polygonTemplate.strokeWidth = 0.5;
// polygonTemplate.fill = am4core.color("#74B266");
polygonTemplate.propertyFields.fill = "fill";


// Create hover state and set alternative fill color
var hs = polygonTemplate.states.create("hover");
hs.properties.fill = "#FFEBCD";
    </script>
  </body>
</html>