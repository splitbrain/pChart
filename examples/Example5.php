<?php

/*
  Example5 : A limits graph
 */

// Standard inclusions   
require_once("../lib/pData.php");
require_once("../lib/pChart.php");
require_once '../lib/GDCanvas.php';
require_once '../lib/BackgroundStyle.php';

// Dataset definition 
$DataSet = new pData;
$DataSet->addPoints(array(1, 4, -3, 2, -3, 3, 2, 1, 0, 7, 4, -3, 2, -3, 3, 5, 1, 0, 7), "Serie1");
$DataSet->addPoints(array(2, 5, 7, 5, 1, 5, 6, 4, 8, 4, 0, 2, 5, 6, 4, 5, 6, 7, 6), "Serie2");
$DataSet->AddAllSeries();
$DataSet->SetAbscissaLabelSeries();
$DataSet->SetSeriesName("January", "Serie1");
$DataSet->SetSeriesName("February", "Serie2");

// Initialise the graph
$canvas = new GDCanvas(700, 230);
$Test = new pChart(700, 230, $canvas);
$Test->setFontProperties("../Fonts/tahoma.ttf", 8);
$Test->setGraphArea(50, 30, 585, 200);
$canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240), 1, 0, ShadowProperties::NoShadow());
$backgroundStyle = new BackgroundStyle(new Color(255), TRUE);
$Test->drawGraphBackground($backgroundStyle);

$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0, 2, TRUE);
$Test->drawGrid(new GridStyle(4, TRUE, new Color(230), 50));

// Draw the 0 line
$Test->setFontProperties("../Fonts/tahoma.ttf", 6);
$Test->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

// Draw the limit graph
$Test->drawLimitsGraph($DataSet->GetData(), $DataSet->GetDataDescription(), new Color(180));

// Finish the graph
$Test->setFontProperties("../Fonts/tahoma.ttf", 8);
$Test->drawLegend(600, 30, $DataSet->GetDataDescription(), new Color(255));
$Test->setFontProperties("../Fonts/tahoma.ttf", 10);
$Test->drawTitle(50, 22, "Example 5", new Color(50), 585);
$Test->Render("Example5.png");
?>