<?php

require_once dirname(__FILE__).'/Color.php';
require_once dirname(__FILE__).'/Point.php';
require_once dirname(__FILE__).'/ShadowProperties.php';

interface ICanvas {
	function drawRoundedRectangle(Point $corner1, Point $corner2, $radius, Color $color);

	function drawLine(Point $point1, Point $point2, Color $color, $graphFunction = false);

	function drawDottedLine(Point $point1, Point $point2, $dotSize, Color $color, $graphFunction = false);

	function drawAntialiasPixel(Point $point, Color $color, ShadowProperties $shadowProperties, $alpha);
}