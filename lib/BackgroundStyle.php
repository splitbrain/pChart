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

require_once(dirname(__FILE__).'/Color.php');

class BackgroundStyle {
	public function __construct(Color $gradientStartColor = null, $gradientDecay = null) {
		$this->gradientStartColor = $gradientStartColor;
		$this->gradientDecay = $gradientDecay;
	}

	public function useGradient() {
		return $this->gradientStartColor != null;
	}

	public function getGradientStartColor() {
		if ($this->gradientStartColor == null) {
			throw new Exception("Requested gradient start color, but gradient is not enabled");
		}

		return $this->gradientStartColor;
	}

	public function getGradientDecay() {
		if ($this->gradientStartColor == null) {
			throw new Exception("Requested gradient decay, but gradient is not enabled");
		}
		
		return $this->gradientDecay;
	}

	private $gradientStartColor;

	private $gradientDecay;
}