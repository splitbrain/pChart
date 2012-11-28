<?php
/**
 * Example 3: an overlayed bar graph
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
$DataSet->AddPoints(array(1, 4, -3, 2, -3, 3, 2, 1, 0, 7, 4, -3, 2, -3, 3, 5, 1, 0, 7), "Serie1");
$DataSet->AddPoints(array(0, 3, -4, 1, -2, 2, 1, 0, -1, 6, 3, -4, 1, -4, 2, 4, 0, -1, 6), "Serie2");
$DataSet->AddAllSeries();
$DataSet->setAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");

// Initialise the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(50, 30, 585, 200);
$canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$canvas->drawRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230), 1, 0, ShadowProperties::NoShadow());
$Chart->drawGraphBackground(new BackgroundStyle(new Color(255), TRUE));
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2, TRUE);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(255), TRUE));

// Draw the 0 line
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the bar graph
$Chart->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());

// Finish the graph
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(600, 30, $DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("$DIR/../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(50, 22, "Example 3", new Color(50), 585);
$Chart->Render(OUTDIR."/Example3.png");
