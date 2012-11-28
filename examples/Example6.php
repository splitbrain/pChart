<?php

/**
 * Example 6: A simple filled line graph
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
CSVImporter::importFromCSV($DataSet, dirname(__FILE__)."/../sample/datawithtitle.csv", ",", array(1, 2, 3), TRUE, 0);
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries();

// Initialise the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(60, 30, 680, 200);
$Canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$Canvas->drawFilledRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230), 1, 0, ShadowProperties::NoShadow());

$backgroundStyle = new BackgroundStyle(new Color(255), TRUE);
$Chart->drawGraphBackground($backgroundStyle);

$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230), 50));

// Draw the 0 line
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the filled line graph
$Chart->drawFilledLineGraph($DataSet->getData(), $DataSet->getDataDescription(), 50, True);

// Finish the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(65, 35, $DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(60, 22, "Example 6", new Color(50), 585);

$Chart->Render(OUTDIR."/Example6.png");
