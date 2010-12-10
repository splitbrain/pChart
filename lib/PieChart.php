<?php

/**
 *    pChart - a PHP class to build charts!
 *    Copyright (C) 2008 Jean-Damien POGOLOTTI
 *    Version 2.0 
 *    Copyright (C) 2010 Tim Martin
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

require_once(dirname(__FILE__).'/pChart.php');

/**
 * This is an attempt to separate out the pie chart drawing code from
 * the rest of the chart code, since pie charts are very different
 * from charts that use 2D Cartesian coordinates.
 *
 * The inheritance hierarchy here probably isn't the finished article;
 * separating out in this way is an intermediate form that I hope will
 * shed light on the real dependency structure.
 */
class PieChart extends pChart {
	/**
	 * Draw the data legends 
	 */
	public function drawPieLegend($XPos, $YPos, $Data, $DataDescription, Color $color, ShadowProperties $shadowProperties = null) {
		if ($shadowProperties == null) {
			$shadowProperties = ShadowProperties::NoShadow();
		}

		/* Validate the Data and DataDescription array */
		$this->validateDataDescription ( "drawPieLegend", $DataDescription, FALSE );
		$this->validateData ( "drawPieLegend", $Data );
		
		if ($DataDescription->getPosition() == '')
			return (- 1);
		
		/* <-10->[8]<-4->Text<-10-> */
		$MaxWidth = 0;
		$MaxHeight = 8;
		foreach ( $Data as $Key => $Value ) {
			$Value2 = $Value [$DataDescription->getPosition()];
			$Position = imageftbbox ( $this->FontSize, 0, $this->FontName, $Value2 );
			$TextWidth = $Position [2] - $Position [0];
			$TextHeight = $Position [1] - $Position [7];
			if ($TextWidth > $MaxWidth) {
				$MaxWidth = $TextWidth;
			}
			
			$MaxHeight = $MaxHeight + $TextHeight + 4;
		}
		$MaxHeight = $MaxHeight - 3;
		$MaxWidth = $MaxWidth + 32;
		
		$this->canvas->drawFilledRoundedRectangle(new Point($XPos + 1, $YPos + 1),
												  new Point($XPos + $MaxWidth + 1,
															$YPos + $MaxHeight + 1),
												  5,
												  $color->addRGBIncrement(-30),
												  $this->LineWidth,
												  $this->LineDotSize,
												  $shadowProperties);
		
		$this->canvas->drawFilledRoundedRectangle(new Point($XPos, $YPos), 
												  new Point($XPos + $MaxWidth,
															$YPos + $MaxHeight), 
												  5, $color,
												  $this->LineWidth,
												  $this->LineDotSize,
												  $shadowProperties);
		
		$YOffset = 4 + $this->FontSize;
		$ID = 0;
		foreach ( $Data as $Key => $Value ) {
			$Value2 = $Value [$DataDescription->getPosition()];
			$Position = imageftbbox ( $this->FontSize, 0, $this->FontName, $Value2 );
			$TextHeight = $Position [1] - $Position [7];
			$this->canvas->drawFilledRectangle(new Point($XPos + 10,
														 $YPos + $YOffset - 6),
											   new Point($XPos + 14,
														 $YPos + $YOffset - 2),
											   $this->palette->colors[$ID],
											   $shadowProperties);
			
			$this->canvas->drawText($this->FontSize,
									0,
									new Point($XPos + 22,
											  $YPos + $YOffset),
									new Color(0, 0, 0),
									$this->FontName,
									$Value2,
									ShadowProperties::NoShadow());
			$YOffset = $YOffset + $TextHeight + 4;
			$ID ++;
		}
	}
}