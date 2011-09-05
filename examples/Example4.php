<?php

/*
  Example4 : Showing how to draw area
 */

// Standard inclusions   
require_once("../lib/pData.php");
require_once("../lib/pChart.php");
require_once("../lib/CSVImporter.php");
require_once '../lib/GDCanvas.php';
require_once '../lib/BackgroundStyle.php';

// Definitions
$DataSet = new pData;
$canvas = new GDCanvas(700, 230);
$Chart = new pChart(700, 230, $canvas);
// Dataset definition
CSVImporter::ImportFromCSV($DataSet, "../sample/datawithtitle.csv", ",", array(1, 2, 3), TRUE, 0);
$DataSet->AddAllSeries();
$DataSet->setAbscissaLabelSeries();

// Initialise the graph
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(60, 30, 680, 200);
$canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$canvas->drawRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230), 1, 0, ShadowProperties::NoShadow());
$Chart->drawGraphBackground(new BackgroundStyle(new Color(255), TRUE));
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230, 230, 230), TRUE));

// Draw the 0 line
$Chart->setFontProperties("../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the area
$Chart->drawArea($DataSet, "Serie 1", "Serie 3", new Color(239, 238, 227));

// Draw the line graph
$Chart->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
$Chart->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, new Color(255));

// Finish the graph
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(65, 35, $DataSet->GetDataDescription(), new Color(250));
$Chart->setFontProperties("../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(60, 22, "Example 4", new Color(50), 585);
$Chart->Render("Example4.png");

header("Content-Type:image/png");
readfile("Example4.png");
?>