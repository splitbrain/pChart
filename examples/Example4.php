<?php

/**
 * Example 4: Showing how to draw area
 */

// Standard setup
$DIR = dirname(__FILE__);
if(!defined('OUTDIR')) define('OUTDIR', $DIR);
require_once("$DIR/../lib/pChart.php");

// Definitions
$DataSet = new pData;
$canvas  = new GDCanvas(700, 230);
$Chart   = new pChart(700, 230, $canvas);
// Dataset definition
CSVImporter::ImportFromCSV($DataSet, "$DIR/../sample/datawithtitle.csv", ",", array(1, 2, 3), TRUE, 0);
$DataSet->AddAllSeries();
$DataSet->setAbscissaLabelSeries();

// Initialise the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(60, 30, 680, 200);
$canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$canvas->drawRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230), 1, 0, ShadowProperties::NoShadow());
$Chart->drawGraphBackground(new BackgroundStyle(new Color(255), TRUE));
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230, 230, 230), TRUE));

// Draw the 0 line
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the area
$Chart->drawArea($DataSet, "Serie 1", "Serie 3", new Color(239, 238, 227));

// Draw the line graph
$Chart->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
$Chart->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, new Color(255));

// Finish the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(65, 35, $DataSet->GetDataDescription(), new Color(250));
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(60, 22, "Example 4", new Color(50), 585);
$Chart->Render(OUTDIR."/Example4.png");
