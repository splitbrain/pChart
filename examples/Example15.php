<?php
/*
    Example15 : Playing with line style & pictures inclusion
*/

// Standard inclusions
require_once("../lib/pData.php");
require_once '../lib/GDCanvas.php';
require_once("../lib/pChart.php");
require_once '../lib/BackgroundStyle.php';

// Dataset definition
$DataSet = new pData;
$Canvas  = new GDCanvas(700, 230);
$Chart = new pChart(700, 230, $Canvas);

$DataSet->AddPoints(array(10, 9.4, 7.7, 5, 1.7, -1.7, -5, -7.7, -9.4, -10, -9.4, -7.7, -5, -1.8, 1.7), "Serie1");
$DataSet->AddPoints(array(0, 3.4, 6.4, 8.7, 9.8, 9.8, 8.7, 6.4, 3.4, 0, -3.4, -6.4, -8.6, -9.8, -9.9), "Serie2");
$DataSet->AddPoints(array(7.1, 9.1, 10, 9.7, 8.2, 5.7, 2.6, -0.9, -4.2, -7.1, -9.1, -10, -9.7, -8.2, -5.8), "Serie3");
$DataSet->AddPoints(array("Jan", "Jan", "Jan", "Feb", "Feb", "Feb", "Mar", "Mar", "Mar", "Apr", "Apr", "Apr", "May", "May", "May"), "Serie4");
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries("Serie4");
$DataSet->setSeriesName("Max Average", "Serie1");
$DataSet->setSeriesName("Min Average", "Serie2");
$DataSet->setSeriesName("Temperature", "Serie3");
$DataSet->SetYAxisName("Temperature");
$DataSet->SetXAxisName("Month of the year");

// Initialise the graph
$Chart->setFixedScale(-12, 12, 5);
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(65, 30, 570, 185);

$Canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$Canvas->drawRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230), 1, 0, ShadowProperties::NoShadow());

$Chart->drawGraphBackground(new BackgroundStyle(new Color(255), true));
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230), 50));

// Draw the 0 line
$Chart->setFontProperties("../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the area
$DataSet->removeSeriesName("Serie4");
$Chart->drawArea($DataSet, "Serie1", "Serie2", new Color(239, 238, 227));
$DataSet->removeSeriesName("Serie3");
$Chart->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());

// Draw the line graph
$Chart->setLineStyle(1, 6);
$DataSet->removeAllSeries();
$DataSet->AddSeries("Serie3");
$Chart->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
$Chart->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, new Color(255));

// Write values on Serie3
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->writeValues($DataSet->GetData(), $DataSet->GetDataDescription(), "Serie3");

// Finish the graph
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(590, 90, $DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(60, 22, "Example 15", new Color(50), 585);

// Add an image
$Chart->drawFromPNG("../Sample/logo.png", 584, 35);

// Render the chart
$Chart->Render("Example15.png");
header("Content-Type:image/png");
readfile("Example15.png");
