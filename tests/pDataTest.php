<?php

require_once 'PHPUnit/Framework/TestCase.php';

require_once 'lib/pData.php';

class pDataTest extends PHPUnit_Framework_TestCase {
	public function testAddPointAssociative() {
		$data = new pData();

		$data->addPoint(array(3 => 4, 4 => 5));

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

		$this->assertEquals(array(0 => array('Serie1' => 1,
											 'Name' => 0)),
							$data->getData());

		$data->addPoint(array(2, 3, 4));

		$this->assertEquals(array(0 => array('Serie1' => 1,
											 'Name' => 0),
								  1 => array('Serie1' => 2,
											 'Name' => 1),
								  2 => array('Serie1' => 3,
											 'Name' => 2),
								  3 => array('Serie1' => 4,
											 'Name' => 3)),
							$data->getData());
	}

	public function testAddSeries() {
		$data = new pData;

		$data->addSeries('testseries1');
		$data->addSeries('testseries2');

		// Adding the same series a second time should have no effect
		$data->addSeries('testseries2');

		$data->addPoint(array(1, 2), 'testseries1');
		$data->addPoint(array(3, 4), 'testseries2');

		$this->assertEquals(array(0 => array('testseries1' => 1,
											 'testseries2' => 3,
											 'Name' => 0),
								  1 => array('testseries1' => 2,
											 'testseries2' => 4,
											 'Name' => 1)),
							$data->getData());
	}
}