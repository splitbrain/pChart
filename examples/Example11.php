<?php

/**
 * Example 11: Using the pCache class
 */

// Standard setup
$DIR = dirname(__FILE__);
if(!defined('OUTDIR')) define('OUTDIR', $DIR);
require_once("$DIR/../lib/pChart.php");

// Definitions
$DataSet = new pData;
$Canvas  = new GDCanvas(700, 230);
$Chart   = new pChart(700, 230, $Canvas);
// Dataset 
$DataSet->AddPoints(array(1, 4, 3, 2, 3, 3, 2, 1, 0, 7, 4, 3, 2, 3, 3, 5, 1, 0, 7), "Serie1");
$DataSet->AddPoints(array(1, 4, 2, 6, 2, 3, 0, 1, 5, 1, 2, 4, 5, 2, 1, 0, 6, 4, 2), "Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");

// Cache definition 
$Cache = new pCache();
$Cache->GetFromCache("Example11", $DataSet->GetData());
// Initialise the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(50, 30, 585, 200);
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230), 50));

// Draw the 0 line
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the cubic curve graph
$Chart->drawCubicCurve($DataSet, .1, "Serie1");
$Chart->drawCubicCurve($DataSet, .1, "Serie2");

// Finish the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(600, 30, $DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(50, 22, "Example 1", new Color(50), 585);

// Render the graph
$Cache->WriteToCache("Example11", $DataSet->GetData(), $Chart);
$Chart->Render(OUTDIR."/Example11.png");
header("Content-Type:image/png");
readfile(OUTDIR."/Example11.png");