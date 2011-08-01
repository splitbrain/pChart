<?php

/*
  Example3 : an overlayed bar graph, uggly no?
 */

// Standard inclusions   
require_once("../lib/pData.php");
require_once("../lib/pChart.php");
require_once('../lib/GDCanvas.php');
require_once '../lib/BackgroundStyle.php';

// Dataset definition 
$DataSet = new pData;
$DataSet->AddPoints(array(1, 4, -3, 2, -3, 3, 2, 1, 0, 7, 4, -3, 2, -3, 3, 5, 1, 0, 7), "Serie1");
$DataSet->AddPoints(array(0, 3, -4, 1, -2, 2, 1, 0, -1, 6, 3, -4, 1, -4, 2, 4, 0, -1, 6), "Serie2");
$DataSet->AddAllSeries();
$DataSet->setAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");

// Initialise the graph
$canvas = new GDCanvas(700, 230);
$Test = new pChart(700, 230, $canvas);
$Test->setFontProperties("../Fonts/tahoma.ttf", 8);
$Test->setGraphArea(50, 30, 585, 200);
$canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240, 240, 240), 1, 0, ShadowProperties::NoShadow());
$canvas->drawRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230, 230, 230), 1, 0, ShadowProperties::NoShadow());
$Test->drawGraphBackground(new BackgroundStyle(new Color(255, 255, 255), TRUE));
$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2, TRUE);
$Test->drawGrid(new GridStyle(4, TRUE, new Color(255, 255, 255), TRUE));

// Draw the 0 line
$Test->setFontProperties("../Fonts/tahoma.ttf", 6);
$Test->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the bar graph
$Test->drawOverlayBarGraph($DataSet->GetData(), $DataSet->GetDataDescription());

// Finish the graph
$Test->setFontProperties("../Fonts/tahoma.ttf", 8);
$Test->drawLegend(600, 30, $DataSet->GetDataDescription(), new Color(255, 255, 255));
$Test->setFontProperties("../Fonts/tahoma.ttf", 10);
$Test->drawTitle(50, 22, "Example 3", new Color(50, 50, 50), 585);
$Test->Render("Example3.png");
?>