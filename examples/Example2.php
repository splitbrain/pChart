<?php

/*
  Example2 : A cubic curve graph
 */

// Standard inclusions   
require_once '../lib/pChart.php';
require_once '../lib/PieChart.php';
require_once '../lib/pData.php';
require_once '../lib/GDCanvas.php';
require_once '../lib/TestCanvas.php';
require_once '../lib/GridStyle.php';
require_once '../lib/BackgroundStyle.php';
require_once '../lib/ScaleStyle.php';
require_once '../lib/CSVImporter.php';

// Definitions
$DataSet = new pData;
$Canvas = new GDCanvas(700, 230);
$Chart = new pChart(700, 230, $Canvas);
//Dataset
$DataSet->AddPoints(array(1, 4, 3, 4, 3, 3, 2, 1, 0, 7, 4, 3, 2, 3, 3, 5, 1, 0, 7), "Serie1");
$DataSet->AddPoints(array(1, 4, 2, 6, 2, 3, 0, 1, 5, 1, 2, 4, 5, 2, 1, 0, 6, 4, 2), "Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");

// Initialise the graph
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(50, 30, 585, 200);

// Canvas
//$Canvas->setAntialiasQuality(0);
$Canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$Canvas->drawRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230), 1, 0, ShadowProperties::NoShadow());

$Chart->drawGraphBackground(new BackgroundStyle(new Color(255)), TRUE);
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), TRUE, 0, 2);
$Chart->drawGrid(new GridStyle(4,TRUE,new Color(230),50));

// Draw the 0 line
$Chart->setFontProperties("../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the cubic curve graph
$Chart->drawFilledCubicCurve($DataSet, .1, 50);
//$Chart->drawCubicCurve($DataSet, .1, 50);

// Finish the graph
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(600,30,$DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(50,22,"Example 2", new Color(50),585);
$Chart->Render("Example2.png");

header("Content-Type:image/png");
readfile("Example2.png");
?>