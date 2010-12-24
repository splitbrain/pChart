<?php

require_once 'PHPUnit/Framework/TestCase.php';

require_once 'lib/pData.php';

class pDataTest extends PHPUnit_Framework_TestCase {
	public function testAddPointAssociative() {
		$data = new pData();

		$data->addPoints(array(3 => 4, 4 => 5));

		/* NB: Key values passed in the array to addPoint are
		 discarded */
		$this->assertEquals(array(0 => array('Series1' => 4,
											 'Name' => 0),
								  1 => array('Series1' => 5,
											 'Name' => 1)),
							$data->getData());
	}

	public function testAddPoint() {
		$data = new pData();
		
		$data->addPoint(1);

		$this->assertEquals(array(0 => array('Series1' => 1,
											 'Name' => 0)),
							$data->getData());

		$data->addPoints(array(2, 3, 4));

		$this->assertEquals(array(0 => array('Series1' => 1,
											 'Name' => 0),
								  1 => array('Series1' => 2,
											 'Name' => 1),
								  2 => array('Series1' => 3,
											 'Name' => 2),
								  3 => array('Series1' => 4,
											 'Name' => 3)),
							$data->getData());
	}

	public function testAddSeries() {
		$data = new pData;

		$data->addSeries('testseries1');
		$data->addSeries('testseries2');

		// Adding the same series a second time should have no effect
		$data->addSeries('testseries2');

		$data->addPoints(array(1, 2), 'testseries1');
		$data->addPoints(array(3, 4), 'testseries2');

		$this->assertEquals(array(0 => array('testseries1' => 1,
											 'testseries2' => 3,
											 'Name' => 0),
								  1 => array('testseries1' => 2,
											 'testseries2' => 4,
											 'Name' => 1)),
							$data->getData());
	}

	public function testAddAllSeries() {
		$data = new pData;

		$data->addPoints(array(1, 2), 'testseries1');
		$data->addPoints(array(3, 4), 'testseries2');

		$data->addAllSeries();

		/** @todo It's not clear how to test the effect of
		 addAllSeries(). The assertion below passes whether or not
		 addAllSeries() has been called */

		$this->assertEquals(array(0 => array('testseries1' => 1,
											 'testseries2' => 3,
											 'Name' => 0),
								  1 => array('testseries1' => 2,
											 'testseries2' => 4,
											 'Name' => 1)),
							$data->getData());
	}

	public function testRemoveSeries() {
		$data = new pData;

		$data->addPoints(array(1, 2), 'testseries1');
		$data->addPoints(array(3, 4), 'testseries2');

		$data->addSeries('testseries1');
		$data->addSeries('testseries2');

		$this->assertEquals(array('testseries1', 
								  'testseries2'),
							$data->getDataDescription()->values);

		$this->assertEquals(null,
							$data->getDataDescription()->description);
		
		$data->removeSeries('testseries1');

		$this->assertEquals(array(1 => 'testseries2'),
							$data->getDataDescription()->values);
	}

	public function testGetXYMap() {
		$data = new pData;

		$data->addPoints(array(2, 3, 4, 5), 'series1');
		$data->addPoints(array(4, 3, 2, 1), 'series2');

		$xIn = array();
		$yIn = array();
		$missing = array();
		$data->getXYMap('series1', $xIn, $yIn, $missing, $index);

		$this->assertEquals(4, $index);
		$this->assertEquals(array(0, 1, 2, 3, 4),
							$xIn);
		$this->assertEquals(array(0, 2, 3, 4, 5),
							$yIn);
		$this->assertEquals(array(),
							$missing);
	}
}