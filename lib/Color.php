<?php

/**
 *    pChart - a PHP class to build charts!
 *
 *    http://pchart.sourceforge.net
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

class Color {
	public function __construct($red, $green, $blue) {
		if ($red < 0 || $red > 255) {
			throw new InvalidArgumentException("Invalid Red component");
		}

		if ($green < 0 || $green > 255) {
			throw new InvalidArgumentException("Invalid Green component");
		}

		if ($blue < 0 || $blue > 255) {
			throw new InvalidArgumentException("Invalid Blue component");
		}

		$this->r = $red;
		$this->g = $green;
		$this->b = $blue;
	}

	public $r;
	public $g;
	public $b;
}