<?php   
 /*
     Example1 : A simple line chart
 */

 // Standard inclusions      
 require_once("../lib/pData.php");   
 require_once("../lib/pChart.php");   
require_once('../lib/GDCanvas.php');
require_once('../lib/Color.php');
  
 // Dataset definition    
 $DataSet = new pData;   
 $DataSet->ImportFromCSV("../sample/bulkdata.csv",",",array(1,2,3),FALSE,0);   
 $DataSet->AddAllSeries();   
 $DataSet->SetAbscissaLabelSeries();   
 $DataSet->setSeriesName("January","Serie1");   
 $DataSet->setSeriesName("February","Serie2");   
 $DataSet->setSeriesName("March","Serie3");   
$DataSet->getDataDescription()->SetYAxisName("Average age");
$DataSet->getDataDescription()->SetYUnit("µs");
  
 // Initialise the graph   
$Test = new pChart(700,230, new GDCanvas(700, 230));
 $Test->setFontProperties("../Fonts/tahoma.ttf",8);   
 $Test->setGraphArea(70,30,680,200);   
$Test->drawFilledRoundedRectangle(7,7,693,223,5, new Color(240,240,240));   
$Test->drawRoundedRectangle(5,5,695,225,5, new Color(230,230,230));   
$Test->drawGraphArea(new Color(255,255,255),TRUE);
 $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,
				  new Color(150,150,150),TRUE,0,2);   
$Test->drawGrid(4,TRUE, new Color(230,230,230),50);
  
 // Draw the 0 line   
 $Test->setFontProperties("../Fonts/tahoma.ttf",6);   
$Test->drawTreshold(0, new Color(143,55,72),TRUE,TRUE);   
  
 // Draw the line graph
 $Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,new Color(255,255,255));   
  
 // Finish the graph   
 $Test->setFontProperties("../Fonts/tahoma.ttf",8);   
$Test->drawLegend(75,35,$DataSet->GetDataDescription(),new Color(255,255,255));   
 $Test->setFontProperties("../Fonts/tahoma.ttf",10);   
$Test->drawTitle(60,22,"example 1",new Color(50,50,50),585);   
 $Test->Render("example1.png");
?>