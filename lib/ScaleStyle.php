<?php

require_once dirname(__FILE__).'/Color.php';

class ScaleStyle {
	public function __construct($scaleMode) {
		$this->scaleMode = $scaleMode;
	}

	public function getScaleMode() {
		return $this->scaleMode;
	}

	private $scaleMode;
}