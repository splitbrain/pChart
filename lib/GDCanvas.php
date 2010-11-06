<?php

require_once dirname(__FILE__).'/ICanvas.php';

class GDCanvas implements ICanvas {
	public function __construct($xSize, $ySize) {
		$this->picture = imagecreatetruecolor($xSize, $ySize);

		$C_White = $this->allocateColor(new Color(255, 255, 255));
		imagefilledrectangle($this->picture, 0, 0, $xSize, $ySize, $C_White);
		imagecolortransparent($this->picture, $C_White);
	}

	public function drawRoundedRectangle(Point $point1, Point $point2, $radius, Color $color) {
		
	}

	public function drawLine(Point $point1, Point $point2, Color $color, $graphFunction = false) {

	}

	public function drawDottedLine(Point $point1, Point $point2, $dotSize, Color $color, $graphFunction = false) {
		
	}

	public function drawAntialiasPixel(Point $point, Color $color, ShadowProperties $shadowProperties, $alpha = 100) {

	}

	public function drawAlphaPixel(Point $point, $alpha, Color $color) {
		/** @todo Check that the point is within the bounds of the
		 * canvas */

		$RGB2 = imagecolorat ( $this->picture, $point->getX(), $point->getY());
		$R2 = ($RGB2 >> 16) & 0xFF;
		$G2 = ($RGB2 >> 8) & 0xFF;
		$B2 = $RGB2 & 0xFF;
		
		$iAlpha = (100 - $alpha) / 100;
		$alpha = $alpha / 100;
		
		$Ra = floor ( $color->r * $alpha + $R2 * $iAlpha );
		$Ga = floor ( $color->g * $alpha + $G2 * $iAlpha );
		$Ba = floor ( $color->b * $alpha + $B2 * $iAlpha );
		
		$C_Aliased = $this->allocateColor (new Color($Ra, $Ga, $Ba));
		imagesetpixel($this->picture, $point->getX(), $point->getY(), $C_Aliased );
	}

	/**
	 * Color helper 
	 *
	 * @todo This shouldn't need to be public, it's only a temporary
	 * step while refactoring
	 */
	public function allocateColor(Color $color, $Factor = 0) {
		if ($Factor != 0) {
			$color = $color->addRGBIncrement($Factor);
		}
		
		return (imagecolorallocate ($this->picture, $color->r, $color->g, $color->b ));
	}

	/**
	 * @todo This is only a temporary interface while I'm
	 * refactoring. This should eventually be removed.
	 */
	public function getPicture() {
		return $this->picture;
	}

	private $picture;
}