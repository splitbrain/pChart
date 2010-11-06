<?php

require_once dirname(__FILE__).'/ICanvas.php';

class GDCanvas implements ICanvas {
	public function __construct($xSize, $ySize) {
		$this->picture = imagecreatetruecolor($xSize, $ySize);

		$C_White = $this->allocateColor(new Color(255, 255, 255));
		imagefilledrectangle($this->picture, 0, 0, $xSize, $ySize, $C_White);
		imagecolortransparent($this->picture, $C_White);

		$this->antialiasQuality = 0;
	}

	public function drawRoundedRectangle(Point $point1, Point $point2, $radius, Color $color) {
		
	}

	public function drawLine(Point $point1, Point $point2, Color $color, $graphFunction = false) {

	}

	public function drawDottedLine(Point $point1, Point $point2, $dotSize, $lineWidth, Color $color, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null) {
		$Distance = $point1->distanceFrom($point2);

		$XStep = ($point2->getX() - $point1->getX()) / $Distance;
		$YStep = ($point2->getY() - $point1->getY()) / $Distance;
		
		$DotIndex = 0;
		for($i = 0; $i <= $Distance; $i ++) {
			$X = $i * $XStep + $point1->getX();
			$Y = $i * $YStep + $point1->getY();
			
			if ($DotIndex <= $dotSize) {
				if (($boundingBoxMin == null || (($X >= $boundingBoxMin->getX())
												 && ($Y >= $boundingBoxMin->getY())))
					&& ($boundingBoxMax == null || (($X <= $boundingBoxMax->getX())
													&& ($Y <= $boundingBoxMax->getY())))) {
					if ($lineWidth == 1)
						$this->drawAntialiasPixel(new Point($X, $Y),
												  $color, $shadowProperties);
					else {
						$StartOffset = - ($lineWidth / 2);
						$EndOffset = ($lineWidth / 2);
						for($j = $StartOffset; $j <= $EndOffset; $j ++) {
							$this->drawAntialiasPixel(new Point($X + $j,
																$Y + $j),
													  $color, $shadowProperties);
						}
					}
				}
			}
			
			$DotIndex ++;
			if ($DotIndex == $dotSize * 2)
				$DotIndex = 0;
		}		
	}

	public function drawAntialiasPixel(Point $point, Color $color, ShadowProperties $shadowProperties, $alpha = 100) {
		/* Process shadows */
		if ($shadowProperties->active) {
			$this->drawAntialiasPixel(new Point($point->getX() + $shadowProperties->xDistance,
												$point->getY() + $shadowProperties->yDistance),
									  $shadowProperties->color,
									  ShadowProperties::NoShadow(),
									  $shadowProperties->alpha);
			if ($shadowProperties->blur != 0) {
				$AlphaDecay = ($shadowProperties->alpha / $shadowProperties->blur);
				
				for($i = 1; $i <= $shadowProperties->blur; $i ++)
					$this->drawAntialiasPixel(new Point($point->getX() + $shadowProperties->xDistance - $i / 2,
														$point->getY() + $shadowProperties->yDistance - $i / 2),
											  $shadowProperties->color,
											  ShadowProperties::NoShadow(),
											  $shadowProperties->alpha - $AlphaDecay * $i);
				for($i = 1; $i <= $shadowProperties->blur; $i ++)
					$this->drawAntialiasPixel(new Point($point->getX() + $shadowProperties->xDistance + $i / 2,
														$point->getY() + $shadowProperties->yDistance + $i / 2),
											  $shadowProperties->color, 
											  ShadowProperties::NoShadow(),
											  $shadowProperties->alpha - $AlphaDecay * $i);
			}
		}
		
		$Plot = "";
		$Xi = floor ( $point->getX() );
		$Yi = floor ( $point->getY() );
		
		if ($Xi == $point->getX() && $Yi == $point->getY()) {
			if ($alpha == 100) {
				$C_Aliased = $this->allocateColor($color);
				imagesetpixel ( $this->picture, 
								$point->getX(), $point->getY(),
								$C_Aliased );
			} else
				$this->drawAlphaPixel($point, $alpha, $color);
		} else {
			$Alpha1 = (((1 - ($point->getX() - $Xi)) * (1 - ($point->getY() - $Yi)) * 100) / 100) * $alpha;
			if ($Alpha1 > $this->antialiasQuality) {
				$this->drawAlphaPixel(new Point($Xi, $Yi), $Alpha1, $color);
			}
			
			$Alpha2 = ((($point->getX() - $Xi) * (1 - ($point->getY() - $Yi)) * 100) / 100) * $alpha;
			if ($Alpha2 > $this->antialiasQuality) {
				$this->drawAlphaPixel (new Point($Xi + 1, $Yi), $Alpha2, $color);
			}
			
			$Alpha3 = (((1 - ($point->getX() - $Xi)) * ($point->getY() - $Yi) * 100) / 100) 
				* $alpha;
			if ($Alpha3 > $this->antialiasQuality) {
				$this->drawAlphaPixel (new Point($Xi, $Yi + 1), $Alpha3, $color);
			}
			
			$Alpha4 = ((($point->getX() - $Xi) * ($point->getY() - $Yi) * 100) / 100) 
				* $alpha;
			if ($Alpha4 > $this->antialiasQuality) {
				$this->drawAlphaPixel (new Point($Xi + 1, $Yi + 1), $Alpha4, $color);
			}
		}
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

	public function getAntialiasQuality() {
		return $this->antialiasQuality;
	}

	public function setAntialiasQuality($newQuality) {
		if (!is_numeric($newQuality)
			|| $newQuality < 0
			|| $newQuality > 100) {
			throw new InvalidArgumentException("Invalid argument to GDCanvas::setAntialiasQuality()");
		}

		$this->antialiasQuality = $newQuality;
	}

	private $picture;

	/**
	 * Quality of the antialiasing we do: 0 is maximum, 100 is minimum
	 */
	private $antialiasQuality;
}