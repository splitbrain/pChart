<?php

/**
 * Example 5: A limits graph
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
$DataSet->addPoints(array(1, 4, -3, 2, -3, 3, 2, 1, 0, 7, 4, -3, 2, -3, 3, 5, 1, 0, 7), "Serie1");
$DataSet->addPoints(array(2, 5, 7, 5, 1, 5, 6, 4, 8, 4, 0, 2, 5, 6, 4, 5, 6, 7, 6), "Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");

// Initialise the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(50, 30, 585, 200);
$canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$backgroundStyle = new BackgroundStyle(new Color(255), TRUE);
$Chart->drawGraphBackground($backgroundStyle);

$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2, TRUE);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230), 50));

// Draw the 0 line
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the limit graph
$Chart->drawLimitsGraph($DataSet->GetData(), $DataSet->GetDataDescription(), new Color(180));

// Finish the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(600, 30, $DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(50, 22, "Example 5", new Color(50), 585);
$Chart->Render(OUTDIR."/Example5.png");

header("Content-Type:image/png");
readfile(OUTDIR."/Example5.png");