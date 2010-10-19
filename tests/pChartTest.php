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
		$DataSet->importFromCSV(dirname(__FILE__)."/../sample/bulkdata.csv",",",array(1,2,3),FALSE,0);   
		$DataSet->addAllSeries();   
		$DataSet->setAbscissaLabelSeries();   
		$DataSet->setSeriesName("January","Serie1");   
		$DataSet->setSeriesName("February","Serie2");   
		$DataSet->setSeriesName("March","Serie3");   
		$DataSet->setYAxisName("Average age");
		$DataSet->setYAxisUnit("µs");
  
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
	 * Based on Example10.php
	 */
	public function testPieGraph() {
		// Dataset definition 
		$DataSet = new pData();
		$DataSet->AddPoint(array(10, 2, 3, 5, 3), "Serie1");
		$DataSet->AddPoint(array("January", "February", "March", "April", "May"), "Serie2");
		$DataSet->AddAllSeries();
		$DataSet->setAbscissaLabelSeries("Serie2");
		
		// Initialise the graph
		$Test = new pChart(420, 250);
		$Test->drawFilledRoundedRectangle(7, 7, 413, 243, 5, 240, 240, 240);
		$Test->drawRoundedRectangle(5, 5, 415, 245, 5, 230, 230, 230);
		$Test->createColorGradientPalette(195, 204, 56, 223, 110, 41, 5);
		
		// Draw the pie chart
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf", 8);
		$Test->setAntialiasQuality(0);
		$Test->drawPieGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 180, 130, 110, PIE_PERCENTAGE_LABEL, FALSE, 50, 20, 5);
		$Test->drawPieLegend(330, 15, $DataSet->GetData(), 
							 $DataSet->GetDataDescription(), 250, 250, 250);
		
		// Write the title
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/MankSans.ttf", 10);
		$Test->drawTitle(10, 20, "Sales per month", 100, 100, 100);
		$Test->Render(dirname(__FILE__)."/actual/example10.png");

		$expectedContents = file_get_contents(dirname(__FILE__).'/expected/example10.png');
		$actualContents = file_get_contents(dirname(__FILE__).'/actual/example10.png');

		$this->assertEquals($expectedContents, $actualContents);
	}

	public function testFlatPieGraph() {
		// Dataset definition 
		$DataSet = new pData();
		$DataSet->AddPoint(array(10, 2, 3, 5, 3), "Serie1");
		$DataSet->AddPoint(array("Jan", "Feb", "Mar", "Apr", "May"), "Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries("Serie2");
		
		// Initialise the graph
		$Test = new pChart(300, 200);
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf", 8);
		$Test->drawFilledRoundedRectangle(7, 7, 293, 193, 5, 240, 240, 240);
		$Test->drawRoundedRectangle(5, 5, 295, 195, 5, 230, 230, 230);
		
		// Draw the pie chart
		$Test->setAntialiasQuality(0);
		$Test->setShadowProperties(2, 2, 200, 200, 200);
		$Test->drawFlatPieGraphWithShadow($DataSet->GetData(), 
										  $DataSet->GetDataDescription(), 120, 100, 60, PIE_PERCENTAGE, 8);
		$Test->clearShadow();
		$Test->drawPieLegend(230, 15, $DataSet->GetData(), 
							 $DataSet->GetDataDescription(), 250, 250, 250);
		$Test->Render(dirname(__FILE__)."/actual/example13.png");

		$expectedContents = file_get_contents(dirname(__FILE__).'/expected/example13.png');
		$actualContents = file_get_contents(dirname(__FILE__).'/actual/example13.png');
		
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
		
		$DataSet->setSeriesName("Trigonometric function","Serie1");
		$DataSet->addSeries("Serie1");
		$DataSet->addSeries("Serie2");
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
		$DataSet->removeSeries("Serie2");
		$Test->drawLegend(160,5,$DataSet->GetDataDescription(),0,0,0,0,0,0,255,255,255,FALSE);
		
		$Test->Render(dirname(__FILE__)."/actual/example24.png");

		$expectedContents = file_get_contents(dirname(__FILE__).'/expected/example24.png');
		$actualContents = file_get_contents(dirname(__FILE__).'/actual/example24.png');

		$this->assertEquals($expectedContents, $actualContents);
	}

	public function testDrawFilledCubicCurve() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->AddPoint(array(1,4,3,2,3,3,2,1,0,7,4,3,2,3,3,5,1,0,7),"Serie1");
		$DataSet->AddPoint(array(1,4,2,6,2,3,0,1,5,1,2,4,5,2,1,0,6,4,2),"Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();
		$DataSet->SetSeriesName("January","Serie1");
		$DataSet->SetSeriesName("February","Serie2");
		
		// Initialise the graph
		$Test = new pChart(700,230);
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,200);
		$Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);
		$Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);
		$Test->drawGraphArea(255,255,255,TRUE);
		$Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2);
		$Test->drawGrid(4,TRUE,230,230,230,50);
		
		// Draw the 0 line
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,143,55,72,TRUE,TRUE);
		
		// Draw the cubic curve graph
		$Test->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.1,50);
		
		// Finish the graph
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),255,255,255);
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Example 7",50,50,50,585);
		$Test->Render(dirname(__FILE__).'/actual/example7.png');

		$expectedContents = file_get_contents(dirname(__FILE__)
											  .'/expected/example7.png');
		$actualContents = file_get_contents(dirname(__FILE__)
											.'/actual/example7.png');

		$this->assertEquals($expectedContents, $actualContents);
	}

	public function testDrawBasicPieGraph() {
		// Dataset definition 
		$DataSet = new pData();
		$DataSet->AddPoint(array(10, 2, 3, 5, 3), "Serie1");
		$DataSet->AddPoint(array("Jan", "Feb", "Mar", "Apr", "May"), "Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbsciseLabelSerie("Serie2");
		
		// Initialise the graph
		$Test = new pChart(300, 200);
		$Test->loadColorPalette(dirname(__FILE__)."/../Sample/softtones.txt");
		$Test->drawFilledRoundedRectangle(7, 7, 293, 193, 5, 240, 240, 240);
		$Test->drawRoundedRectangle(5, 5, 295, 195, 5, 230, 230, 230);
		
		// This will draw a shadow under the pie chart
		$Test->drawFilledCircle(122, 102, 70, 200, 200, 200);
		
		// Draw the pie chart
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf", 8);
		$Test->setAntialiasQuality(0);
		$Test->drawBasicPieGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 
								 120, 100, 70, PIE_PERCENTAGE, 255, 255, 218);
		$Test->drawPieLegend(230, 15, $DataSet->GetData(), 
							 $DataSet->GetDataDescription(), 250, 250, 250);
		$Test->Render(dirname(__FILE__)."/actual/example14.png");

		$expectedContents = file_get_contents(dirname(__FILE__)
											  .'/expected/example14.png');
		$actualContents = file_get_contents(dirname(__FILE__)
											.'/actual/example14.png');

		$this->assertEquals($expectedContents, $actualContents);
	}

	public function testDrawFilledRadar() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->AddPoint(array("Memory","Disk","Network","Slots","CPU"),"Label");
		$DataSet->AddPoint(array(1,2,3,4,3),"Serie1");
		$DataSet->AddPoint(array(1,4,2,6,2),"Serie2");
		$DataSet->AddSerie("Serie1");
		$DataSet->AddSerie("Serie2");
		$DataSet->SetAbsciseLabelSerie("Label");
		
		
		$DataSet->SetSerieName("Reference","Serie1");
		$DataSet->SetSerieName("Tested computer","Serie2");
		
		// Initialise the graph
		$Test = new pChart(400,400);
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",8);
		$Test->drawFilledRoundedRectangle(7,7,393,393,5,240,240,240);
		$Test->drawRoundedRectangle(5,5,395,395,5,230,230,230);
		$Test->setGraphArea(30,30,370,370);
		$Test->drawFilledRoundedRectangle(30,30,370,370,5,255,255,255);
		$Test->drawRoundedRectangle(30,30,370,370,5,220,220,220);
		
		// Draw the radar graph
		$Test->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,120,120,120,230,230,230);
		$Test->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);
		
		// Finish the graph
		$Test->drawLegend(15,15,$DataSet->GetDataDescription(),255,255,255);
		$Test->setFontProperties(dirname(__FILE__)."/../Fonts/tahoma.ttf",10);
		$Test->drawTitle(0,22,"Example 8",50,50,50,400);
		$Test->Render(dirname(__FILE__)."/actual/example8.png");

		$expectedContents = file_get_contents(dirname(__FILE__)
											  .'/expected/example8.png');
		$actualContents = file_get_contents(dirname(__FILE__)
											.'/actual/example8.png');

		$this->assertEquals($expectedContents, $actualContents);
	}
}