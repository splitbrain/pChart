<?php

require_once dirname(__FILE__).'/Color.php';

class ScaleStyle {
	public function __construct($scaleMode, Color $color, $drawTicks = true) {
		$this->scaleMode = $scaleMode;
		$this->color = $color;
		$this->drawTicks = $drawTicks;
	}

	static public function DefaultStyle() {
		return new ScaleStyle(SCALE_NORMAL,
							  new Color(150, 150, 150));
	}

	public function getScaleMode() {
		return $this->scaleMode;
	}

	public function getColor() {
		return $this->color;
	}

	public function getDrawTicks() {
		return $this->drawTicks;
	}

	private $scaleMode;

	private $color;

	private $drawTicks;
}