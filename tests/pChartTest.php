<?php

require_once 'PHPUnit/Framework/TestCase.php';

require_once 'lib/pChart.php';
require_once 'lib/PieChart.php';
require_once 'lib/pData.php';
require_once 'lib/GDCanvas.php';
require_once 'lib/TestCanvas.php';
require_once 'lib/GridStyle.php';
require_once 'lib/BackgroundStyle.php';
require_once 'lib/ScaleStyle.php';

class pChartTest extends PHPUnit_Framework_TestCase {
	/**
	 * Test generating a chart based on Example1.php in the examples
	 * directory, compare the trace of requests sent to the test
	 * canvas against a known good value
	 */
	public function testLineChart() {
		$canvas = new TestCanvas();

		$DataSet = new pData;   
		$DataSet->importFromCSV(dirname(__FILE__)."/../sample/bulkdata.csv",",",array(1,2,3),FALSE,0);   
		$DataSet->addAllSeries();   
		$DataSet->setAbscissaLabelSeries();   
		$DataSet->setSeriesName("January","Serie1");   
		$DataSet->setSeriesName("February","Serie2");   
		$DataSet->setSeriesName("March","Serie3");   
		$DataSet->getDataDescription()->setYAxisName("Average age");
		$DataSet->getDataDescription()->setYUnit("µs");
  
		// Initialise the graph   
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);   
		$Test->setGraphArea(70,30,680,200);   
		$canvas->drawFilledRoundedRectangle(new Point(7,7),
											new Point(693,223),
											5, new Color(240,240,240),
											1, 0, ShadowProperties::NoShadow());   
		$canvas->drawRoundedRectangle(new Point(5,5),
									  new Point(695,225),
									  5,
									  new Color(230,230,230),
									  1, 0, ShadowProperties::NoShadow());
		$backgroundStyle = new BackgroundStyle(new Color(255,255,255),TRUE);
		$Test->drawGraphBackground($backgroundStyle);

		$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0,2);   

		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));
		
		// Draw the 0 line   
		$Test->setFontProperties("Fonts/tahoma.ttf",6);   
		$Test->drawTreshold(0, new Color(143,55,72), TRUE,TRUE);   
		
		// Draw the line graph
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,
							 new Color(255,255,255));   
  
		// Finish the graph   
		$Test->setFontProperties("Fonts/tahoma.ttf",8);   
		$Test->drawLegend(75,35,$DataSet->GetDataDescription(), new Color(255,255,255));   

		$this->assertEquals(array(73, 51),
							$Test->getLegendBoxSize($DataSet->getDataDescription()));

		$Test->setFontProperties("Fonts/tahoma.ttf",10);   
		$Test->drawTitle(60,22,"example 1", new Color(50,50,50), 585);   

		file_put_contents(dirname(__FILE__).'/action_logs/testLineChart',
						  $canvas->getActionLog());

		$this->assertEquals('589d8e78ac5d19581198a42b75c1c637', md5($canvas->getActionLog()));
	}
	
	/**
	 * Based on Example10.php
	 */
	public function testPieGraph() {
		// Dataset definition 
		$DataSet = new pData();
		$DataSet->addPoints(array(10, 2, 3, 5, 3), "Serie1");
		$DataSet->addPoints(array("January", "February", "March", "April", "May"), "Serie2");
		$DataSet->AddAllSeries();
		$DataSet->setAbscissaLabelSeries("Serie2");
		
		// Initialise the graph
		$canvas = new TestCanvas;
		$canvas->setAntialiasQuality(0);
		$Test = new PieChart(420, 250, $canvas);
		$Test->setPalette(Palette::colorGradientPalette(new Color(195, 204, 56),
														new Color(223, 110, 41),
														5));
		
		// Draw the pie chart
		$Test->setFontProperties("Fonts/tahoma.ttf", 8);
		$Test->drawPieGraph($DataSet, 180, 130, 110, PIE_PERCENTAGE_LABEL, FALSE, 50, 20, 5);
		
		file_put_contents(dirname(__FILE__).'/action_logs/testPieGraph_partial1',
						  $canvas->getActionLog());

		$this->assertEquals('211751485459ed20cc6bac7215db1f20',
							md5($canvas->getActionLog()));

		$Test->drawPieLegend(330, 15, $DataSet->GetData(), 
							 $DataSet->GetDataDescription(),
							 new Color(250, 250, 250));
		
		// Write the title
		$Test->setFontProperties("Fonts/MankSans.ttf", 10);
		$Test->drawTitle(10, 20, "Sales per month", new Color(100, 100, 100));

		file_put_contents(dirname(__FILE__).'/action_logs/testPieGraph',
						  $canvas->getActionLog());

		$this->assertEquals('8302fcc3542fd3f36a9d378efea49d3a',
							md5($canvas->getActionLog()));
	}
	
	public function testFlatPieGraph() {
		// Dataset definition 
		$DataSet = new pData();
		$DataSet->addPoints(array(10, 2, 3, 5, 3), "Serie1");
		$DataSet->addPoints(array("Jan", "Feb", "Mar", "Apr", "May"), "Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries("Serie2");
		
		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new PieChart(300, 200, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf", 8);
		
		// Draw the pie chart
		$Test->setShadowProperties(2, 2, new Color(200, 200, 200));
		$Test->drawFlatPieGraphWithShadow($DataSet->GetData(), 
										  $DataSet->GetDataDescription(), 120, 100, 60, PIE_PERCENTAGE, 8);
		$Test->clearShadow();
		$Test->drawPieLegend(230, 15, $DataSet->GetData(), 
							 $DataSet->GetDataDescription(), new Color(250, 250, 250));

		file_put_contents(dirname(__FILE__).'/action_logs/testFlatPieGraph',
						  $canvas->getActionLog());		

		$this->assertEquals('6fb645a6318014dc9978a1e77ccb9079',
							md5($canvas->getActionLog()));
	}
	
	/**
	 * Based on Example24.php
	 */
	public function testXYChart() {
		// Dataset definition 
		$DataSet = new pData;

		// Compute the points
		for($i=0;$i<=360;$i=$i+10) {
			$DataSet->addPoint(cos($i*3.14/180)*80+$i,"Serie1");
			$DataSet->addPoint(sin($i*3.14/180)*80+$i,"Serie2");
		}
		
		$DataSet->setSeriesName("Trigonometric function","Serie1");
		$DataSet->addSeries("Serie1");
		$DataSet->addSeries("Serie2");
		$DataSet->SetXAxisName("X Axis");
		$DataSet->SetYAxisName("Y Axis");

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(300,300, $canvas);
		$Test->drawBackgroundGradient(new Color(0,0,0),
									  -100);
		
		// Prepare the graph area
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(55,30,270,230);
		$scaleStyle = new ScaleStyle(SCALE_NORMAL,
									 new Color(213, 217, 221));
		$Test->drawXYScale($DataSet,
						   $scaleStyle,
						   "Serie1","Serie2",
						   45);
		
		$backgroundStyle = new BackgroundStyle(new Color(213,217,221),
											   FALSE,
											   new Color(30,30,30),
											   -50);

		$Test->drawGraphBackground($backgroundStyle);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),20));
		
		// Draw the chart
		$Test->setShadowProperties(2,2,
								   new Color(0,0,0),
								   60,4);
		$Test->drawXYGraph($DataSet->GetData(),"Serie1","Serie2",0);
		$Test->clearShadow();
		
		// Draw the title
		$Title = "Drawing X versus Y charts trigonometric functions  ";
		$Test->drawTextBox(new Point(0,280),
						   new Point(300,300),
						   $Title,0,new Color(255,255,255),
						   ALIGN_RIGHT,
						   ShadowProperties::FromSettings(1, 1, new Color(0, 0, 0),
														  100, 0),
						   new Color(0,0,0),
						   30);
		
		// Draw the legend
		$Test->setFontProperties("Fonts/pf_arma_five.ttf",6);
		$DataSet->removeSeries("Serie2");
		$Test->drawLegend(160,5,$DataSet->GetDataDescription(),
						  new Color(0,0,0),
						  new Color(0,0,0),
						  new Color(255,255,255),
						  FALSE);

		file_put_contents(dirname(__FILE__).'/action_logs/testXYChart',
						  $canvas->getActionLog());
		
		$this->assertEquals('29617aa04eb4a3dfe787a5d45733c83c',
							md5($canvas->getActionLog()));
	}

	public function testDrawFilledCubicCurve() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array(1,4,3,2,3,3,2,1,0,7,4,3,2,3,3,5,1,0,7),"Serie1");
		$DataSet->addPoints(array(1,4,2,6,2,3,0,1,5,1,2,4,5,2,1,0,6,4,2),"Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();
		$DataSet->SetSeriesName("January","Serie1");
		$DataSet->SetSeriesName("February","Serie2");
		
		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,200);

		$backgroundStyle = new BackgroundStyle(new Color(255,255,255),TRUE);
		$Test->drawGraphBackground($backgroundStyle);

		$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0,2);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));
		
		// Draw the 0 line
		$Test->setFontProperties("Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,
							new Color(143,55,72),
							TRUE,TRUE);
		
		// Draw the cubic curve graph
		$Test->drawFilledCubicCurve($DataSet, .1, 50);
		
		// Finish the graph
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(), new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Example 7", new Color(50,50,50),585);

		$this->assertEquals('25415e5d96f42f64893657ab2389ea30',
							md5($canvas->getActionLog()));
	}

	public function testDrawBasicPieGraph() {
		// Dataset definition 
		$DataSet = new pData();
		$DataSet->addPoints(array(10, 2, 3, 5, 3), "Serie1");
		$DataSet->addPoints(array("Jan", "Feb", "Mar", "Apr", "May"), "Serie2");
		$DataSet->AddAllSeries();
		$DataSet->setAbscissaLabelSeries("Serie2");
		
		$this->assertEquals(array(0 => array('Serie1' => 10,
											 'Name' => 0,
											 'Serie2' => 'Jan'),
								  1 => array('Serie1' => 2,
											 'Name' => 1,
											 'Serie2' => 'Feb'),
								  2 => array('Serie1' => 3,
											 'Name' => 2,
											 'Serie2' => 'Mar'),
								  3 => array('Serie1' => 5,
											 'Name' => 3,
											 'Serie2' => 'Apr'),
								  4 => array('Serie1' => 3,
											 'Name' => 4,
											 'Serie2' => 'May')),
							$DataSet->getData());

        $this->assertEquals(array(0 => 'Serie1',
								  1 => 'Serie2'),
							$DataSet->getDataDescription()->values);

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new PieChart(300, 200, $canvas);
		$Test->loadColorPalette(dirname(__FILE__)."/../sample/softtones.txt");
		
		// Draw the pie chart
		$Test->setFontProperties("Fonts/tahoma.ttf", 8);
		$Test->drawBasicPieGraph($DataSet->GetData(), $DataSet->GetDataDescription(), 
								 120, 100, 70, PIE_PERCENTAGE, new Color(255, 255, 218));
		$Test->drawPieLegend(230, 15, $DataSet->GetData(), 
							 $DataSet->GetDataDescription(), new Color(250, 250, 250));

		$this->assertEquals('0ec1d5de67ae53239101143106d5ee4a',
							md5($canvas->getActionLog()));
	}

	public function testDrawFilledRadar() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array("Memory","Disk","Network","Slots","CPU"),"Label");
		$DataSet->addPoints(array(1,2,3,4,3),"Serie1");
		$DataSet->addPoints(array(1,4,2,6,2),"Serie2");
		$DataSet->AddSeries("Serie1");
		$DataSet->AddSeries("Serie2");
		$DataSet->setAbscissaLabelSeries("Label");
		
		
		$DataSet->setSeriesName("Reference","Serie1");
		$DataSet->setSeriesName("Tested computer","Serie2");
		
		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(400,400, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(30,30,370,370);
		
		// Draw the radar graph
		$Test->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,
							 new Color(120,120,120),
							 new Color(230,230,230));
		$Test->drawFilledRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50,20);
		
		// Finish the graph
		$Test->drawLegend(15,15,$DataSet->GetDataDescription(),
						  new Color(255,255,255));

		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(0,22,"Example 8",new Color(50,50,50),400);

		$this->assertEquals('c2db8bcd7112711a97e8f1798ddd77e5',
							md5($canvas->getActionLog()));
	}

	public function testDrawRadar() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array("Memory","Disk","Network","Slots","CPU"),"Label");
		$DataSet->addPoints(array(1,2,3,4,3),"Serie1");
		$DataSet->addPoints(array(1,4,2,6,2),"Serie2");
		$DataSet->AddSeries("Serie1");
		$DataSet->AddSeries("Serie2");
		$DataSet->SetAbscissaLabelSeries("Label");
		
		$DataSet->SetSeriesName("Reference","Serie1");
		$DataSet->SetSeriesName("Tested computer","Serie2");
		
		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(400,400, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(30,30,370,370);
		
		// Draw the radar graph
		$Test->drawRadarAxis($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,20,new Color(120,120,120),new Color(230,230,230));
		$Test->drawRadar($DataSet->GetData(),$DataSet->GetDataDescription(),50);
		
		// Finish the graph
		$Test->drawLegend(15,15,$DataSet->GetDataDescription(),new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(0,22,"Example 8",new Color(50,50,50),400);

		$this->assertEquals('be9f2fb9cb890e3ffdae443376d80be9',
							md5($canvas->getActionLog()));
	}

	public function testDrawXYPlotGraph() {
		$dataSet = new pData;

		$dataSet->addPoints(array(1, 3, 2, 6, 3, 1), 'X');
		$dataSet->addPoints(array(5, 2, 4, 12, 7, 3), 'Y');

		$dataSet->addSeries('X');
		$dataSet->addSeries('Y');

		$canvas = new TestCanvas;
		$chart = new pChart(300, 300, $canvas);
		$chart->setFontProperties('Fonts/tahoma.ttf', 8);
		$chart->setGraphArea(55, 30, 270, 230);
		$scaleStyle = new ScaleStyle(SCALE_NORMAL,
									 new Color(213, 217, 221));
		$chart->drawXYScale($dataSet,
							$scaleStyle,
							'Y',
							'X',
							45);

		$backgroundStyle = new BackgroundStyle(new Color(213, 217, 221), FALSE);

		$chart->drawGraphBackground($backgroundStyle);
		$chart->drawGrid(new GridStyle(4, TRUE, new Color(230, 230, 230), 20));

		$chart->drawXYPlotGraph($dataSet->getData(),
								'Y',
								'X');

		file_put_contents(dirname(__FILE__).'/action_logs/testDrawXYPlotGraph',
						  $canvas->getActionLog());

		$this->assertEquals('a769bf6298734bb20665fc27f7f462ab',
							md5($canvas->getActionLog()));
	}

	public function testLabels() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array(0,70,70,0,0,70,70,0,0,70),"Serie1");
		$DataSet->addPoints(array(0.5,2,4.5,8,12.5,18,24.5,32,40.5,50),"Serie2");

		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();
		$DataSet->SetSeriesName("January","Serie1");
		$DataSet->SetSeriesName("February","Serie2");

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,200);
		$backgroundStyle = new BackgroundStyle(new Color(255,255,255),TRUE);
		$Test->drawGraphBackground($backgroundStyle);

		$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0,2);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));

		// Draw the 0 line
		$Test->setFontProperties("Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,new Color(143,55,72),TRUE,TRUE);

		// Draw the line graph
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,
							 new Color(255,255,255));

		// Set labels
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie1","2","Daily incomes",
						new Color(221,230,174));
		$Test->setLabel($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie2","6","Production break",
						new Color(239,233,195));

		// Finish the graph
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Example 9",new Color(50,50,50),585);

		$this->assertEquals('9388dd3d1a53242b48d730c9256cf03e',
							md5($canvas->getActionLog()));
	}

	public function testDrawFilledLineGraph() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->ImportFromCSV(dirname(__FILE__)
								."/../sample/datawithtitle.csv",",",array(1,2,3),TRUE,0);
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(60,30,680,200);

		$backgroundStyle = new BackgroundStyle(new Color(255,255,255), TRUE);

		$Test->drawGraphBackground($backgroundStyle);

		$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0,2);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));

		// Draw the 0 line
		$Test->setFontProperties("Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,new Color(143,55,72),TRUE,TRUE);

		// Draw the filled line graph
		$Test->drawFilledLineGraph($DataSet->GetData(),$DataSet->GetDataDescription(),50,TRUE);

		// Finish the graph
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(65,35,$DataSet->GetDataDescription(),new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(60,22,"Example 6",new Color(50,50,50),585);
		
		$this->assertEquals('9816ffbe4277df46fdce89cdc0b28a47',
							md5($canvas->getActionLog()));
	}

	public function testDrawOverlayBarGraph() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array(1,4,-3,2,-3,3,2,1,0,7,4,-3,2,-3,3,5,1,0,7),"Serie1");
		$DataSet->addPoints(array(0,3,-4,1,-2,2,1,0,-1,6,3,-4,1,-4,2,4,0,-1,6),"Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();
		$DataSet->SetSeriesName("January","Serie1");
		$DataSet->SetSeriesName("February","Serie2");

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,200);
		$canvas->drawFilledRoundedRectangle(new Point(7,7),
											new Point(693,223),
											5,new Color(240,240,240),
											1, 0, ShadowProperties::NoShadow());

		$backgroundStyle = new BackgroundStyle(new Color(255,255,255),TRUE);

		$Test->drawGraphBackground($backgroundStyle);

		$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0,2,TRUE);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));

		// Draw the 0 line
		$Test->setFontProperties("Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,new Color(143,55,72),TRUE,TRUE);

		// Draw the bar graph
		$Test->drawOverlayBarGraph($DataSet->GetData(),$DataSet->GetDataDescription());

		// Finish the graph
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Example 3",new Color(50,50,50),585);

		$this->assertEquals('8c6b50852e15c261e6a40595eed7e283',
							md5($canvas->getActionLog()));
	}

	public function testDrawBarGraph() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array(1,4,-3,2,-3,3,2,1,0,7,4),"Serie1");
		$DataSet->addPoints(array(3,3,-4,1,-2,2,1,0,-1,6,3),"Serie2");
		$DataSet->addPoints(array(4,1,2,-1,-4,-2,3,2,1,2,2),"Serie3");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();
		$DataSet->setSeriesName("January","Serie1");
		$DataSet->setSeriesName("February","Serie2");
		$DataSet->setSeriesName("March","Serie3");

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,680,200);
		$canvas->drawFilledRoundedRectangle(new Point(7,7),
											new Point(693,223),
											5, new Color(240,240,240),
											1, 0, ShadowProperties::NoShadow());
		$backgroundStyle = new BackgroundStyle(new Color(255,255,255),TRUE);

		$Test->drawGraphBackground($backgroundStyle);

		$Test->drawScale($DataSet, ScaleStyle::DefaultStyle(), 0,2,TRUE);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));

		// Draw the 0 line
		$Test->setFontProperties("Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,new Color(143,55,72),TRUE,TRUE);

		// Draw the bar graph
		$Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE,80);

		// Finish the graph
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(596,150,$DataSet->GetDataDescription(),new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Example 12",new Color(50,50,50),585);

		$this->assertEquals('c5cc595cf2c41c6c363521346c8262a5',
							md5($canvas->getActionLog()));
	}

	public function testDrawStackedBarGraph() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array(1,4,-3,2,-3,3,2,1,0,7,4),"Serie1");
		$DataSet->addPoints(array(3,3,-4,1,-2,2,1,0,-1,6,3),"Serie2");
		$DataSet->addPoints(array(4,1,2,-1,-4,-2,3,2,1,2,2),"Serie3");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();
		$DataSet->SetSeriesName("January","Serie1");
		$DataSet->SetSeriesName("February","Serie2");
		$DataSet->SetSeriesName("March","Serie3");

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,680,200);
		$canvas->drawFilledRoundedRectangle(new Point(7,7),
											new Point(693,223),
											5, new Color(240,240,240),
											1, 0, ShadowProperties::NoShadow());
		$backgroundStyle = new BackgroundStyle(new Color(255,255,255),TRUE);
		$Test->drawGraphBackground($backgroundStyle);
		$scaleStyle = new ScaleStyle(SCALE_ADDALL,
									 new Color(150,150,150));
		$Test->drawScale($DataSet, $scaleStyle, 0,2,TRUE);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));

		// Draw the 0 line
		$Test->setFontProperties("Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,new Color(143,55,72),TRUE,TRUE);

		// Draw the bar graph
		$Test->drawStackedBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),100);

		// Finish the graph
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(596,150,$DataSet->GetDataDescription(),new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Example 20",new Color(50,50,50),585);

		$this->assertEquals('9981801f58bf03e0b2bbe5f8b8f36c2c',
							md5($canvas->getActionLog()));
	}

	public function testDrawLimitsGraph() {
		// Dataset definition 
		$DataSet = new pData;
		$DataSet->addPoints(array(1,4,-3,2,-3,3,2,1,0,7,4,-3,2,-3,3,5,1,0,7),"Serie1");
		$DataSet->addPoints(array(2,5,7,5,1,5,6,4,8,4,0,2,5,6,4,5,6,7,6),"Serie2");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries();
		$DataSet->SetSeriesName("January","Serie1");
		$DataSet->SetSeriesName("February","Serie2");

		// Initialise the graph
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->setGraphArea(50,30,585,200);
		$canvas->drawFilledRoundedRectangle(new Point(7,7),
											new Point(693,223),
											5,new Color(240,240,240),
											1, 0, ShadowProperties::NoShadow());
		$backgroundStyle = new BackgroundStyle(new Color(255,255,255),TRUE);
		$Test->drawGraphBackground($backgroundStyle);

		$Test->drawScale($DataSet,
						 ScaleStyle::DefaultStyle(),
						 0,2,TRUE);
		$Test->drawGrid(new GridStyle(4,TRUE,new Color(230,230,230),50));

		// Draw the 0 line
		$Test->setFontProperties("Fonts/tahoma.ttf",6);
		$Test->drawTreshold(0,new Color(143,55,72),TRUE,TRUE);

		// Draw the limit graph
		$Test->drawLimitsGraph($DataSet->GetData(),$DataSet->GetDataDescription(),
							   new Color(180,180,180));

		// Finish the graph
		$Test->setFontProperties("Fonts/tahoma.ttf",8);
		$Test->drawLegend(600,30,$DataSet->GetDataDescription(),new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);
		$Test->drawTitle(50,22,"Example 5",new Color(50,50,50),585);
		
		$this->assertEquals('6964c6d67548ec50af551f396ef0cb09',
							md5($canvas->getActionLog()));
	}

	public function testDrawArea() {
		// Dataset definition    
		$DataSet = new pData;
		$DataSet->addPoints(array(10,9.4,7.7,5,1.7,-1.7,-5,-7.7,-9.4,-10,-9.4,-7.7,-5,-1.8,1.7),"Serie1");
		$DataSet->addPoints(array(0,3.4,6.4,8.7,9.8,9.8,8.7,6.4,3.4,0,-3.4,-6.4,-8.6,-9.8,-9.9),"Serie2");
		$DataSet->addPoints(array(7.1,9.1,10,9.7,8.2,5.7,2.6,-0.9,-4.2,-7.1,-9.1,-10,-9.7,-8.2,-5.8),"Serie3");
		$DataSet->addPoints(array("Jan","Jan","Jan","Feb","Feb","Feb","Mar","Mar","Mar","Apr","Apr","Apr","May","May","May"),"Serie4");
		$DataSet->AddAllSeries();
		$DataSet->SetAbscissaLabelSeries("Serie4");
		$DataSet->SetSeriesName("Max Average","Serie1");
		$DataSet->SetSeriesName("Min Average","Serie2");
		$DataSet->SetSeriesName("Temperature","Serie3");
		$DataSet->SetYAxisName("Temperature");
		$DataSet->SetXAxisName("Month of the year");
  
		// Initialise the graph   
		$canvas = new TestCanvas;
		$Test = new pChart(700,230, $canvas);
		$Test->reportWarnings("GD");
		$Test->setFixedScale(-12,12,5);
		$Test->setFontProperties("Fonts/tahoma.ttf",8);   
		$Test->setGraphArea(65,30,570,185);   
		$canvas->drawFilledRoundedRectangle(new Point(7,7),
											new Point(693,223),
											5, new Color(240,240,240),
											1, 0, ShadowProperties::NoShadow());
		$backgroundStyle = new BackgroundStyle(new Color(255,255,255), TRUE);
		$Test->drawGraphBackground($backgroundStyle);
		$scaleStyle = new ScaleStyle(SCALE_NORMAL,
									 new Color(150,150,150));
		$Test->drawScale($DataSet,
						 $scaleStyle,
						 0,2,TRUE,3);   
		$Test->drawGrid(new GridStyle(4,TRUE, new Color(230,230,230), 50));

		// Draw the 0 line   
		$Test->setFontProperties("Fonts/tahoma.ttf",6);   
		$Test->drawTreshold(0, new Color(143,55,72),TRUE,TRUE);   
  
		// Draw the area
		$DataSet->RemoveSeries("Serie4");
		$Test->drawArea($DataSet->GetData(),"Serie1","Serie2", 
						new Color(239,238,227),
						50);
		$DataSet->RemoveSeries("Serie3");
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   

		// Draw the line graph
		$Test->setLineStyle(1,6);
		$DataSet->RemoveAllSeries();
		$DataSet->AddSeries("Serie3");
		$Test->drawLineGraph($DataSet->GetData(),$DataSet->GetDataDescription());   
		$Test->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,
							 2,
							 new Color(255,255,255));

		// Write values on Serie3
		$Test->setFontProperties("Fonts/tahoma.ttf",8);   
		$Test->writeValues($DataSet->GetData(),$DataSet->GetDataDescription(),"Serie3");   
  
		// Finish the graph   
		$Test->setFontProperties("Fonts/tahoma.ttf",8);   
		$Test->drawLegend(590,90,$DataSet->GetDataDescription(), 
						  new Color(255,255,255));
		$Test->setFontProperties("Fonts/tahoma.ttf",10);   
		$Test->drawTitle(60,22,"example 15", new Color(50,50,50),585);

		// Add an image
		$Test->drawFromPNG(dirname(__FILE__)."/../Sample/logo.png",584,35);

		$this->assertEquals('53b34d556af518230b7556e19349bd94',
							md5($canvas->getActionLog()));
	}
}