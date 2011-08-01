<?php
 /*
     Example4 : Showing how to draw area
 */

 // Standard inclusions   
 require_once("../lib/pData.php");
 require_once("../lib/pChart.php");
 require_once("../lib/CSVImporter.php");
 require_once '../lib/GDCanvas.php';
 require_once '../lib/BackgroundStyle.php';

 // Dataset definition 
 $DataSet = new pData;
 CSVImporter::ImportFromCSV($DataSet, "../sample/datawithtitle.csv", ",",array(1,2,3),TRUE,0);
 $DataSet->AddAllSeries();
 $DataSet->setAbscissaLabelSeries();

 // Initialise the graph
 $canvas = new GDCanvas(700, 230);
 $Test = new pChart(700,230, $canvas);
 $Test->setFontProperties("../Fonts/tahoma.ttf",8);
 $Test->setGraphArea(60,30,680,200);
 $canvas->drawFilledRoundedRectangle(new Point(7, 7), new Point(693, 223), 5, new Color(240, 240, 240), 1, 0, ShadowProperties::NoShadow());
 $canvas->drawRoundedRectangle(new Point(5, 5), new Point(695, 225), 5, new Color(230, 230, 230), 1, 0, ShadowProperties::NoShadow());
 $Test->drawGraphBackground(new BackgroundStyle(new Color(255, 255, 255), TRUE));
 $Test->drawScale($DataSet, ScaleStyle::DefaultStyle(),0,2);
 $Test->drawGrid(new GridStyle(4, TRUE, new Color(230, 230, 230), TRUE));

 // Draw the 0 line
 $Test->setFontProperties("../Fonts/tahoma.ttf",6);
 $Test->drawTreshold(0, new Color(143, 55, 72), TRUE, TRUE);

 // Draw the area
 $Test->drawArea($DataSet, "Serie 1", "Serie 3", new Color(239, 238, 227));

 // Draw the line graph
 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
 $Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2, new Color(255, 255, 255));

 // Finish the graph
 $Test->setFontProperties("../Fonts/tahoma.ttf",8);
 $Test->drawLegend(65,35,$DataSet->GetDataDescription(), new Color(250, 250, 250));
 $Test->setFontProperties("../Fonts/tahoma.ttf",10);
 $Test->drawTitle(60,22,"Example 4", new Color(50, 50, 50),585);
 $Test->Render("Example4.png");
?>