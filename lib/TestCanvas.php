<?php

require_once dirname(__FILE__).'/ICanvas.php';

class TestCanvas implements ICanvas {
	function drawRectangle(Point $corner1, Point $corner2, Color $color, $lineWidth, $lineDotSize, ShadowProperties $shadowProperties) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawFilledRectangle(Point $corner1, Point $corner2, Color $color,
								 ShadowProperties $shadowProperties,
								 $drawBorder = false,
								 $alpha = 100,
								 $lineWidth = 1,
								 $lineDotSize = 0) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawRoundedRectangle(Point $corner1, Point $corner2, $radius,
								  Color $color, $lineWidth, $lineDotSize,
								  ShadowProperties $shadowProperties) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawFilledRoundedRectangle(Point $point1, Point $point2, $radius,
										Color $color, $lineWidth, $lineDotSize,
										ShadowProperties $shadowProperties) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawLine(Point $point1, Point $point2, Color $color, $lineWidth, $lineDotSize, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawDottedLine(Point $point1, Point $point2, $dotSize, $lineWidth, Color $color, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawAntialiasPixel(Point $point, Color $color, ShadowProperties $shadowProperties, $alpha) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawText($fontSize, $angle, Point $point, Color $color, $fontName, $text, ShadowProperties $shadowProperties) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	/**
	 * @todo The function's called drawCircle(), but you can make it
	 * draw an ellipse by passing in different values for width and
	 * height. This should be changed.
	 */
	function drawCircle(Point $center, $height, Color $color, ShadowProperties $shadowProperties, $width) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	function drawFilledCircle(Point $center, $height, Color $color, ShadowProperties $shadowProperties, $width = null) {
		$this->actionLog .= __METHOD__.'('.implode(', ', func_get_args()).")\n";
	}

	public function getActionLog() {
		return $this->actionLog;
	}

	private $actionLog = '';
}