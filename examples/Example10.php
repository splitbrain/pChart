<?php
/**
 * Example 10: A 3D exploded pie graph
 */

// Standard setup
$DIR = dirname(__FILE__);
if(!defined('OUTDIR')) define('OUTDIR', $DIR);
require_once("$DIR/../lib/pChart.php");

// Definitions
$DataSet = new pData;
$Canvas  = new GDCanvas(420, 250);
$Chart   = new PieChart(420, 250, $Canvas);
// Dataset 
$DataSet->AddPoints(array(10, 2, 3, 5, 3), "Serie1");
$DataSet->AddPoints(array("January", "February", "March", "April", "May"), "Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries("Serie2");

// Initialise the graph
$Chart->setPalette(Palette::colorGradientPalette(new Color(195, 204, 56), new Color(223, 110, 41), 5));

// Draw the pie chart
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Canvas->setAntialiasQuality(0);
$Chart->drawPieGraph($DataSet, 180, 130, 110, PIE_PERCENTAGE_LABEL, FALSE, 50, 20, 5);
$Chart->drawPieLegend(330, 15, $DataSet->GetData(), $DataSet->GetDataDescription(), new Color(250));

// Write the title
$Chart->setFontProperties("$DIR/../Fonts/MankSans.ttf", 10);
$Chart->drawTitle(10, 20, "Sales per month", new Color(100));
$Chart->Render(OUTDIR."/Example10.png");
