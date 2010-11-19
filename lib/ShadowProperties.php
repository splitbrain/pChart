<?php

/**
 *    pChart - a PHP class to build charts!
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 1,2,3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class ShadowProperties {
	private function __construct() {

	}

	static public function FromDefaults() {
		$properties = new ShadowProperties;

		$properties->active = false;

		return $properties;
	}

	static public function FromSettings($xDistance, $yDistance, Color $color, $alpha, $blur) {
		$properties = new ShadowProperties;

		$properties->active = true;
		$properties->xDistance = $xDistance;
		$properties->yDistance = $yDistance;
		$properties->color = $color;
		$properties->alpha = $alpha;
		$properties->blur = $blur;

		return $properties;
	}

	static public function NoShadow() {
		return self::FromDefaults();
	}

	public function __toString() {
		return sprintf("ShadowProperties<%d, %d, %d, %s, %d, %d>",
					   $this->active, $this->xDistance, $this->yDistance,
					   $this->color, $this->alpha, $this->blur);
	}

	public $active;
	public $xDistance;
	public $yDistance;
	public $color;
	public $alpha;
	public $blur;
}