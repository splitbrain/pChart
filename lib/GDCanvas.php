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

	public function drawRoundedRectangle(Point $point1, Point $point2, $radius, Color $color, $lineWidth, $lineDotSize, ShadowProperties $shadowProperties) {
		$C_Rectangle = $this->allocateColor($color);
		
		$Step = 90 / ((M_PI * $radius) / 2);
		
		for($i = 0; $i <= 90; $i = $i + $Step) {
			$X = cos ( ($i + 180) * M_PI / 180 ) * $radius + $point1->getX() + $radius;
			$Y = sin ( ($i + 180) * M_PI / 180 ) * $radius + $point1->getY() + $radius;
			$this->drawAntialiasPixel(new Point($X, $Y), $color, $shadowProperties);
			
			$X = cos ( ($i - 90) * M_PI / 180 ) * $radius + $point2->getX() - $radius;
			$Y = sin ( ($i - 90) * M_PI / 180 ) * $radius + $point1->getY() + $radius;
			$this->drawAntialiasPixel(new Point($X, $Y), $color, $shadowProperties);
			
			$X = cos ( ($i) * M_PI / 180 ) * $radius + $point2->getX() - $radius;
			$Y = sin ( ($i) * M_PI / 180 ) * $radius + $point2->getY() - $radius;
			$this->drawAntialiasPixel(new Point($X, $Y), $color, $shadowProperties);
			
			$X = cos ( ($i + 90) * M_PI / 180 ) * $radius + $point1->getX() + $radius;
			$Y = sin ( ($i + 90) * M_PI / 180 ) * $radius + $point2->getY() - $radius;
			$this->drawAntialiasPixel(new Point($X, $Y), $color, $shadowProperties);
		}
		
		$X1 = $point1->getX() - .2;
		$Y1 = $point1->getY() - .2;
		$X2 = $point2->getX() + .2;
		$Y2 = $point2->getY() + .2;
		$this->drawLine(new Point($X1 + $radius, $Y1),
						new Point($X2 - $radius, $Y1),
						$color,
						$lineWidth,
						$lineDotSize,
						$shadowProperties);

		$this->drawLine(new Point($X2, $Y1 + $radius),
						new Point($X2, $Y2 - $radius),
						$color,
						$lineWidth,
						$lineDotSize,
						$shadowProperties);

		$this->drawLine(new Point($X2 - $radius, $Y2),
						new Point($X1 + $radius, $Y2),
						$color,
						$lineWidth,
						$lineDotSize,
						$shadowProperties);

		$this->drawLine(new Point($X1, $Y2 - $radius),
						new Point($X1, $Y1 + $radius),
						$color,
						$lineWidth,
						$lineDotSize,
						$shadowProperties);		
	}

	/**
	 * This function creates a filled rectangle with rounded corners
	 * and antialiasing
	 */
	function drawFilledRoundedRectangle(Point $point1, Point $point2, $radius,
										Color $color, $lineWidth, $lineDotSize,
										ShadowProperties $shadowProperties) {
		$C_Rectangle = $this->allocateColor($color);
		
		$Step = 90 / ((M_PI * $radius) / 2);
		
		for($i = 0; $i <= 90; $i = $i + $Step) {
			$Xi1 = cos ( ($i + 180) * M_PI / 180 ) * $radius 
				+ $point1->getX() 
				+ $radius;

			$Yi1 = sin ( ($i + 180) * M_PI / 180 ) * $radius 
				+ $point1->getY() 
				+ $radius;
			
			$Xi2 = cos ( ($i - 90) * M_PI / 180 ) * $radius 
				+ $point2->getX() 
				- $radius;

			$Yi2 = sin ( ($i - 90) * M_PI / 180 ) * $radius 
				+ $point1->getY()
				+ $radius;
			
			$Xi3 = cos ( ($i) * M_PI / 180 ) * $radius 
				+ $point2->getX() 
				- $radius;

			$Yi3 = sin ( ($i) * M_PI / 180 ) * $radius 
				+ $point2->getY() 
				- $radius;
			
			$Xi4 = cos ( ($i + 90) * M_PI / 180 ) * $radius
				+ $point1->getX()
				+ $radius;

			$Yi4 = sin ( ($i + 90) * M_PI / 180 ) * $radius
				+ $point2->getY() 
				- $radius;
			
			imageline($this->picture,
					  $Xi1, $Yi1, 
					  $point1->getX() + $radius, $Yi1,
					  $C_Rectangle);

			imageline($this->picture, $point2->getX() - $radius, $Yi2,
					  $Xi2, $Yi2,
					  $C_Rectangle);

			imageline($this->picture,
					  $point2->getX() - $radius, $Yi3,
					  $Xi3, $Yi3,
					  $C_Rectangle);

			imageline($this->picture,
					  $Xi4, $Yi4,
					  $point1->getX() + $radius, $Yi4,
					  $C_Rectangle );
			
			$this->drawAntialiasPixel(new Point($Xi1, $Yi1),
									  $color,
									  $shadowProperties);
			$this->drawAntialiasPixel(new Point($Xi2, $Yi2),
									  $color,
									  $shadowProperties);
			$this->drawAntialiasPixel(new Point($Xi3, $Yi3),
									  $color,
									  $shadowProperties);
			$this->drawAntialiasPixel(new Point($Xi4, $Yi4),
									  $color,
									  $shadowProperties);
		}
		
		imagefilledrectangle($this->picture,
							 $point1->getX(), $point1->getY() + $radius,
							 $point2->getX(), $point2->getY() - $radius,
							 $C_Rectangle);

		imagefilledrectangle($this->picture,
							 $point1->getX() + $radius, $point1->getY(),
							 $point2->getX() - $radius, $point2->getY(),
							 $C_Rectangle);
		
		$X1 = $point1->getX() - .2;
		$Y1 = $point1->getY() - .2;
		$X2 = $point2->getX() + .2;
		$Y2 = $point2->getY() + .2;
		$this->drawLine(new Point($X1 + $radius, $Y1),
						new Point($X2 - $radius, $Y1),
						$color,
						$lineWidth, $lineDotSize,
						$shadowProperties);

		$this->drawLine(new Point($X2, $Y1 + $radius),
						new Point($X2, $Y2 - $radius),
						$color,
						$lineWidth, $lineDotSize,
						$shadowProperties);
		
		$this->drawLine(new Point($X2 - $radius, $Y2),
						new Point($X1 + $radius, $Y2),
						$color,
						$lineWidth, $lineDotSize,
						$shadowProperties);

		$this->drawLine(new Point($X1, $Y2 - $radius),
						new Point($X1, $Y1 + $radius),
						$color,
						$lineWidth, $lineDotSize,
						$shadowProperties);

	}


	public function drawLine(Point $point1, Point $point2, Color $color, $lineWidth, $lineDotSize, ShadowProperties $shadowProperties, Point $boundingBoxMin = null, Point $boundingBoxMax = null) {
		if ($lineDotSize > 1) {
			$this->drawDottedLine($point1,
								  $point2,
								  $lineDotSize, $lineWidth,
								  $color, $shadowProperties,
								  $boundingBoxMin,
								  $boundingBoxMax);
			return;
		}
		
		$Distance = $point1->distanceFrom($point2);
		if ($Distance == 0)
			return;
		$XStep = ($point2->getX() - $point1->getX()) / $Distance;
		$YStep = ($point2->getY() - $point1->getY()) / $Distance;
		
		for($i = 0; $i <= $Distance; $i ++) {
			$X = $i * $XStep + $point1->getX();
			$Y = $i * $YStep + $point1->getY();
			
			if ((($boundingBoxMin == null) || (($X >= $boundingBoxMin->getX())
											   && ($Y >= $boundingBoxMin->getY())))
				&& (($boundingBoxMax == null) || (($X <= $boundingBoxMax->getX())
												  && ($Y <= $boundingBoxMax->getY())))) {
				if ($lineWidth == 1)
					$this->drawAntialiasPixel(new Point($X, $Y), $color, $shadowProperties);
				else {
					$StartOffset = - ($lineWidth / 2);
					$EndOffset = ($lineWidth / 2);
					for($j = $StartOffset; $j <= $EndOffset; $j ++)
						$this->drawAntialiasPixel(new Point($X + $j, $Y + $j),
												  $color, $shadowProperties);
				}
			}
		}
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