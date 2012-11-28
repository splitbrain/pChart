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
}
