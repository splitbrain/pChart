<?php

require_once dirname(__FILE__).'/Color.php';
require_once dirname(__FILE__).'/Point.php';

interface ICanvas {
	function drawRoundedRectangle(Point $corner1, Point $corner2, $radius, Color $color);
}