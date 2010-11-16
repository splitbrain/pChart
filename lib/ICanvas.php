<?php

require_once dirname(__FILE__).'/Color.php';
require_once dirname(__FILE__).'/Point.php';
require_once dirname(__FILE__).'/ShadowProperties.php';

interface ICanvas {
	function drawFilledRectangle(Point $corner1, Point $corner2, Color $color,
								 ShadowProperties $shadowProperties, $drawBorder,
								 $alpha, $lineWidth, $lineDotSize);

	function drawRoundedRectangle(Point $corner1, Point $corner2, $radius,
								  Color $color, $lineWidth, $lineDotSize,
								  ShadowProperties $shadowProperties);

	function drawFilledRoundedRectangle(Point $point1, Point $point2, $radius,
										Color $color, $lineWidth, $lineDotSize,
										ShadowProperties $shadowProperties);

	function drawLine(Point $point1, Point $point2, Color $color, $lineWidth, $lineDotSize, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null);

	function drawDottedLine(Point $point1, Point $point2, $dotSize, $lineWidth, Color $color, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null);

	function drawAntialiasPixel(Point $point, Color $color, ShadowProperties $shadowProperties, $alpha);

	function drawText($fontSize, $angle, Point $point, Color $color, $fontName, $text, ShadowProperties $shadowProperties);

	/**
	 * @todo The function's called drawCircle(), but you can make it
	 * draw an ellipse by passing in different values for width and
	 * height. This should be changed.
	 */
	function drawCircle(Point $center, $height, Color $color, ShadowProperties $shadowProperties, $width);
}