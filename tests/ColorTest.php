<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once dirname(__FILE__).'/../lib/Color.php';

class colorTest extends PHPUnit_Framework_TestCase {

    function testGetHex(){
        $color = new Color(255, 0, 0);
        $this->assertEquals('#ff0000', $color->getHex());

        $color = new Color(5, 0, 0);
        $this->assertEquals('#050000', $color->getHex());
    }

    function testFromHex(){
        $color = new Color('#ff0000');
        $this->assertEquals('#ff0000', $color->getHex());

        $color = new Color('#050000');
        $this->assertEquals('#050000', $color->getHex());
    }

    function testUnicolor(){
        $color = new Color(0);
        $this->assertEquals(0, $color->getR(), 'black');
        $this->assertEquals(0, $color->getG(), 'black');
        $this->assertEquals(0, $color->getB(), 'black');

        $color = new Color(255);
        $this->assertEquals(255, $color->getR(), 'white');
        $this->assertEquals(255, $color->getG(), 'white');
        $this->assertEquals(255, $color->getB(), 'white');

        $color = new Color(128);
        $this->assertEquals(128, $color->getR(), 'gray');
        $this->assertEquals(128, $color->getG(), 'gray');
        $this->assertEquals(128, $color->getB(), 'gray');

        $color = new Color(128, 255);
        $this->assertEquals(128, $color->getR(), 'pink');
        $this->assertEquals(255, $color->getG(), 'pink');
        $this->assertEquals(128, $color->getB(), 'pink');
    }
}
