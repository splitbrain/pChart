<?php

require_once 'PHPUnit/Framework/TestCase.php';

require_once 'lib/pChart.php';

class pChartTest extends PHPUnit_Framework_TestCase {
	/**
	 * Trivial test: can we construct a pChart?
	 */
	public function testConstruct() {
		$chart = new pChart(320, 240);
	}

	/**
	 * Test generating a chart based on Example1.php in the examples
	 * directory, doing a binary compare of the file against a known
	 * good value.
	 */
	public function testLineChart() {
		$DataSet = new pData;   
		$DataSet->ImportFromCSV(dirname(__FILE__)."/../sample/bulkdata.csv",",",array(1,2,3),FALSE,0);   
		$DataSet->AddAllSeries();   
		$DataSet->SetAbsciseLabelSerie();   
		$DataSet->SetSerieName("January","Serie1");   
		$DataSet->SetSerieName("February","Serie2");   
		$DataSet->SetSerieName("March","Serie3");   
		$DataSet->SetYAxisName("Average age");
		$DataSet->SetYAxisUnit("µs");
  
		// Initialise the graph   
		$Test = new pChart(700,230);
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",8);   
		$Test->setGraphArea(70,30,680,200);   
		$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);   
		$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);   
		$Test->drawGraphArea(255,255,255,TRUE);
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);   
		$Test->drawGrid(4,TRUE,230,230,230,50);
		
		// Draw the 0 line   
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",6);   
		$Test->drawTreshold(0,143,55,72,TRUE,TRUE);   
		
		// Draw the line graph
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);   
  
		// Finish the graph   
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",8);   
		$Test->drawLegend(75,35,$DataSet->GetDataDescription(),255,255,255);   
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",10);   
		$Test->drawTitle(60,22,"example 1",50,50,50,585);   
		$Test->Render(dirname(__FILE__)."/actual/example1.png");

		$expectedContents = file_get_contents(dirname(__FILE__).'/expected/example1.png');
		$actualContents = file_get_contents(dirname(__FILE__).'/actual/example1.png');

		$this->assertEquals($expectedContents, $actualContents);
	}

	/**
	 * Based on Example24.php
	 */
	public function testXYChart() {
		// Dataset definition 
		$DataSet = new pData;

		// Compute the points
		for($i=0;$i<=360;$i=$i+10) {
			$DataSet->AddPoint(cos($i*3.14/180)*80+$i,"Serie1");
			$DataSet->AddPoint(sin($i*3.14/180)*80+$i,"Serie2");
		}
		
		$DataSet->SetSerieName("Trigonometric function","Serie1");
		$DataSet->AddSerie("Serie1");
		$DataSet->AddSerie("Serie2");
		$DataSet->SetXAxisName("X Axis");
		$DataSet->SetYAxisName("Y Axis");

		// Initialise the graph
		$Test = new pChart(300,300);
		$Test->drawGraphAreaGradient(0,0,0,-100,TARGET_BACKGROUND);
		
		// Prepare the graph area
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",8);
		$Test->setGraphArea(55,30,270,230);
		$Test->drawXYScale($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","Serie2",213,217,221,TRUE,45);
		$Test->drawGraphArea(213,217,221,FALSE);
		$Test->drawGraphAreaGradient(30,30,30,-50);
		$Test->drawGrid(4,TRUE,230,230,230,20);
		
		// Draw the chart
		$Test->setShadowProperties(2,2,0,0,0,60,4);
		$Test->drawXYGraph($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","Serie2",0);
		$Test->clearShadow();
		
		// Draw the title
		$Title = "Drawing X versus Y charts trigonometric functions  ";
		$Test->drawTextBox(0,280,300,300,$Title,0,255,255,255,ALIGN_RIGHT,TRUE,0,0,0,30);
		
		// Draw the legend
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/pf_arma_five.ttf",6);
		$DataSet->RemoveSerie("Serie2");
		$Test->drawLegend(160,5,$DataSet->GetDataDescription(),0,0,0,0,0,0,255,255,255,FALSE);
		
		$Test->Render(dirname(__FILE__)."/actual/example24.png");

		$expectedContents = file_get_contents(dirname(__FILE__).'/expected/example24.png');
		$actualContents = file_get_contents(dirname(__FILE__).'/actual/example24.png');

		$this->assertEquals($expectedContents, $actualContents);
	}
}