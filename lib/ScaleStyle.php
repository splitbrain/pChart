<?php

require_once dirname(__FILE__).'/Color.php';

class ScaleStyle {
	public function __construct($scaleMode, Color $color) {
		$this->scaleMode = $scaleMode;
		$this->color = $color;
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