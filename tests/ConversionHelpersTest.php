<?php

require_once 'PHPUnit/Framework/TestCase.php';

class ConversionHelpersTest extends PHPUnit_Framework_TestCase {
	public function testToMetric() {
		$this->assertEquals('123.0k', ConversionHelpers::ToMetric(123000));

		$this->assertEquals('123.456m',
							ConversionHelpers::ToMetric(123456000));
	}
}