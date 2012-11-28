<?php
/**
 * Example 16: Importing CSV data
 */

// Standard setup
$DIR = dirname(__FILE__);
if(!defined('OUTDIR')) define('OUTDIR', $DIR);
require_once("$DIR/../lib/pChart.php");

// Dataset definition
$DataSet = new pData;
CSVImporter::importFromCSV($DataSet, "$DIR/../sample/CO2.csv", ",", array(1, 2, 3, 4), TRUE, 0);
$DataSet->AddAllSeries();
$DataSet->setAbscissaLabelSeries();
$DataSet->SetYAxisName("CO2 concentrations");

// Initialise the graph
$Canvas = new GDCanvas(700, 230);
$Chart  = new pChart(700, 230, $Canvas);
$Chart->reportWarnings("GD");
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(60, 30, 680, 180);
// todo these Canvas methods are cuurently not exposed
//$Chart->drawFilledRoundedRectangle(7, 7, 693, 223, 5, 240, 240, 240);
//$Chart->drawRoundedRectangle(5, 5, 695, 225, 5, 230, 230, 230);
$Chart->drawGraphBackground(new BackgroundStyle(new Color(255, 255, 255), TRUE));
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 90, 2);

$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230, 230, 230), 50));

// Draw the 0 line
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the line graph
$Chart->drawLineGraph($DataSet->GetData(), $DataSet->GetDataDescription());
$Chart->drawPlotGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 3, 2, new Color(255, 255, 255));

// Finish the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(70, 40, $DataSet->GetDataDescription(), new Color(255, 255, 255));
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(60, 22, "CO2 concentrations at Mauna Loa", new Color(50, 50, 50), 585);
$Chart->Render(OUTDIR."/Example16.png");