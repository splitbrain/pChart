<?php
/**
 * Example 9: Showing how to use labels
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
$DataSet->AddPoints(array(0, 70, 70, 0, 0, 70, 70, 0, 0, 70), "Serie1");
$DataSet->AddPoints(array(0.5, 2, 4.5, 8, 12.5, 18, 24.5, 32, 40.5, 50), "Serie2");
$DataSet->AddAllSeries();
$DataSet->setAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");

// Initialise the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(50, 30, 585, 200);
$Chart->drawGraphBackground(new BackgroundStyle(new Color(255), TRUE));
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230), 50));

// Draw the 0 line
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the line graph
$Chart->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
$Chart->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, new Color(255));

// Set labels
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setLabel($DataSet->GetData(), $DataSet->GetDataDescription(), "Serie1", "2", "Daily incomes", new Color(221, 230, 174));
$Chart->setLabel($DataSet->GetData(), $DataSet->GetDataDescription(), "Serie2", "6", "Production break", new Color(239, 233, 195));

// Finish the graph
$Chart->drawLegend(600, 30, $DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(50, 22, "Example 9", new Color(50), 585);

$Chart->Render(OUTDIR."/Example9.png");
