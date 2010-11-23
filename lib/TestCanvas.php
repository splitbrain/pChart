<?php

require_once dirname(__FILE__).'/ICanvas.php';

class TestCanvas implements ICanvas {
	function drawRectangle(Point $corner1, Point $corner2, Color $color, $lineWidth, $lineDotSize, ShadowProperties $shadowProperties) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawFilledRectangle(Point $corner1, Point $corner2, Color $color,
								 ShadowProperties $shadowProperties,
								 $drawBorder = false,
								 $alpha = 100,
								 $lineWidth = 1,
								 $lineDotSize = 0) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawRoundedRectangle(Point $corner1, Point $corner2, $radius,
								  Color $color, $lineWidth, $lineDotSize,
								  ShadowProperties $shadowProperties) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawFilledRoundedRectangle(Point $point1, Point $point2, $radius,
										Color $color, $lineWidth, $lineDotSize,
										ShadowProperties $shadowProperties) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawLine(Point $point1, Point $point2, Color $color, $lineWidth, $lineDotSize, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawDottedLine(Point $point1, Point $point2, $dotSize, $lineWidth, Color $color, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawAntialiasPixel(Point $point, Color $color, ShadowProperties $shadowProperties, $alpha = 100) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawText($fontSize, $angle, Point $point, Color $color, $fontName, $text, ShadowProperties $shadowProperties) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	/**
	 * @todo The function's called drawCircle(), but you can make it
	 * draw an ellipse by passing in different values for width and
	 * height. This should be changed.
	 */
	function drawCircle(Point $center, $height, Color $color, ShadowProperties $shadowProperties, $width = null) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawFilledCircle(Point $center, $height, Color $color, ShadowProperties $shadowProperties, $width = null) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function drawFilledPolygon(array $points, $numPoints, Color $color, $alpha = 100) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	function setAntialiasQuality($newQuality) {
		$this->logMethodCall(__METHOD__, func_get_args());
	}

	private function logMethodCall($methodName, $args) {
		$formattedArgs = array();
		foreach ($args as $arg) {
			if (is_array($arg)) {
				$formattedArgs[] = 'array<' . implode(', ', $arg) . '>';
			}
			else {
				$formattedArgs[] = $arg;
			}
		}
		$this->actionLog .= $methodName.'('.implode(', ', $formattedArgs).")\n";
	}

	public function getActionLog() {
		return $this->actionLog;
	}

	private $actionLog = '';
}