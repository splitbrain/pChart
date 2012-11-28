<?php

require_once 'PHPUnit/Framework/TestCase.php';

class ExampleTest extends PHPUnit_Framework_TestCase {

    /**
     * this runs one of the example files as a test case
     *
     * we call this from separate test functions below instead of using a loop to have
     * correctly separated function scopes and test results.
     *
     * @param $num number of the example to run
     */
    function loadexample($num) {
        if(!defined('OUTDIR')) define('OUTDIR', dirname(__FILE__)); //where we store the generated files
        $exampledir = dirname(__FILE__).'/../examples';

        $name = "Example$num";

        // make sure there are no left overs
        if(file_exists(OUTDIR."/$name.png")) unlink(OUTDIR."/$name.png");

        // run the example
        include("$exampledir/$name.php");

        // check the result as good as possible
        $this->assertFileExists(OUTDIR."/$name.png", $name);
        $size = getimagesize(OUTDIR."/$name.png");
        $this->assertTrue(is_array($size), $name);
        // todo we should test the dimensions at least

        // remove file
        if(file_exists(OUTDIR."/$name.png")) unlink(OUTDIR."/$name.png");
    }


    function testExample1() {
        $this->loadexample(1);
    }

    function testExample2() {
        $this->loadexample(2);
    }

    function testExample3() {
        $this->loadexample(3);
    }

    function testExample4() {
        $this->loadexample(4);
    }

    function testExample5() {
        $this->loadexample(5);
    }

    function testExample6() {
        $this->loadexample(6);
    }

    function testExample7() {
        $this->loadexample(7);
    }

    function testExample8() {
        $this->loadexample(8);
    }

    function testExample9() {
        $this->loadexample(9);
    }

    function testExample10() {
        $this->loadexample(10);
    }

    function testExample11() {
        $this->loadexample(11);
    }

    function testExample12() {
        $this->loadexample(12);
    }

    function testExample13() {
        $this->loadexample(13);
    }

    function testExample14() {
        $this->loadexample(14);
    }

    function testExample15() {
        $this->loadexample(15);
    }

    function testExample16() {
        $this->loadexample(16);
    }

    /* tests below are currently broken

        function testExample17() {
            $this->loadexample(17);
        }

        function testExample18() {
            $this->loadexample(18);
        }

        function testExample19() {
            $this->loadexample(19);
        }

        function testExample20() {
            $this->loadexample(20);
        }

        function testExample21() {
            $this->loadexample(21);
        }

        function testExample22() {
            $this->loadexample(22);
        }

        function testExample23() {
            $this->loadexample(23);
        }
    */
}
