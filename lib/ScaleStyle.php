<?php

require_once dirname(__FILE__).'/Color.php';

class ScaleStyle {
	public function __construct($scaleMode, Color $color) {
		$this->scaleMode = $scaleMode;
		$this->color = $color;
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

	private $scaleMode;

	private $color;
}