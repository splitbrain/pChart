<?php

class Point {
	public function __construct($x, $y) {
		$this->x = $x;
		$this->y = $y;
	}

	public function getX() {
		return $this->x;
	}

	public function getY() {
		return $this->y;
	}

	public function distanceFrom(Point $other) {
		return sqrt((($other->x - $this->x) * ($other->x - $this->x))
					+ (($other->y - $this->y) * ($other->y - $this->y)));
	}

	public function __toString() {
		return sprintf("Point<%d, %d>", $this->x, $this->y);
	}

	private $x;
	private $y;
}