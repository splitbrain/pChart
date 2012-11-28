<?php

require_once(dirname(__FILE__).'/Color.php');

class Palette {
    /** @todo Are the keys on this array always numbers, and always
     * sequential?  That's the way it's used in the code, but I don't
     * think we enforce that anywhere. Is enforcing it a sensible
     * thing to do? */
    public $colors = array();

    static public function defaultPalette() {
        $palette = new Palette;

        $palette->colors = array(
            '0' => new Color(188, 224, 46),
            "1" => new Color(224, 100, 46),
            "2" => new Color(224, 214, 46),
            "3" => new Color(46, 151, 224),
            "4" => new Color(176, 46, 224),
            "5" => new Color(224, 46, 117),
            "6" => new Color(92, 224, 46),
            "7" => new Color(224, 176, 46)
        );

        return $palette;
    }

    static public function colorGradientPalette(Color $color1, Color $color2, $shades) {
        $palette = new Palette();

        $RFactor = ($color2->getR() - $color1->getR()) / $shades;
        $GFactor = ($color2->getG() - $color1->getG()) / $shades;
        $BFactor = ($color2->getB() - $color1->getB()) / $shades;

        for($i = 0; $i <= $shades - 1; $i++) {
            $palette->colors[$i] = new Color($color1->getR() + $RFactor * $i,
                                             $color1->getG() + $GFactor * $i,
                                             $color1->getB() + $BFactor * $i);
        }

        return $palette;
    }

    /**
     * Set the color at the specified position
     *
     * @param int   $id
     * @param Color $color
     */
    public function setColor($id, Color $color) {
        $this->colors[$id] = $color;
    }

    /**
     * Get the color at the specified position
     *
     * @param int $id position in the color array
     * @return Color
     */
    public function getColor($id){
        if(isset($this->colors[$id])) return $this->colors[$id];

        // there's no color assigned, create a pseudo random one
        $this->colors[$id] = Color::random($id);
        return $this->colors[$id];
    }
}