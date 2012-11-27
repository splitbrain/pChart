<?php

/*
  Example12 : A true bar graph
 */

// Standard inclusions   
require_once("../lib/pData.php");
require_once("../lib/pChart.php");
require_once '../lib/GDCanvas.php';
require_once '../lib/BackgroundStyle.php';

// Definitions
$DataSet = new pData;
$Canvas  = new GDCanvas(700, 230);
$Chart   = new pChart(700, 230, $Canvas);
// Dataset 
$DataSet->AddPoints(array(1, 4, -3, 2, -3, 3, 2, 1, 0, 7, 4), "Serie1");
$DataSet->AddPoints(array(3, 3, -4, 1, -2, 2, 1, 0, -1, 6, 3), "Serie2");
$DataSet->AddPoints(array(4, 1, 2, -1, -4, -2, 3, 2, 1, 2, 2), "Serie3");
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");
$DataSet->SetSeriesName("March", "Serie3");

// Initialise the graph
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->setGraphArea(50, 30, 680, 200);
$Canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$Chart->drawGraphBackground(new BackgroundStyle(new Color(255), TRUE));
$Chart->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2, TRUE);
$Chart->drawGrid(new GridStyle(4, TRUE, new Color(230), 80));

// Draw the 0 line
$Chart->setFontProperties("../Fonts/tahoma.ttf", 6);
$Chart->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the bar graph
$Chart->drawBarGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 80);

// Finish the graph
$Chart->setFontProperties("../Fonts/tahoma.ttf", 8);
$Chart->drawLegend(596, 150, $DataSet->GetDataDescription(), new Color(255));
$Chart->setFontProperties("../Fonts/tahoma.ttf", 10);
$Chart->drawTitle(50, 22, "Example 12", new Color(50), 585);
$Chart->Render("Example12.png");
header("Content-Type:image/png");
readfile("Example12.png");