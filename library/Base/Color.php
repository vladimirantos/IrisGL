<?php

namespace Iris\Base;

use \Iris\Core;

/**
 * @author Vladimír Antoš
 * @version 1.0
 * @property int $red
 * @property int $green
 * @property int $blue
 * @property int $alpha
 * @property-read float $realRed Vrací červenou složku vyjádřenou jako reálné číslo v rozsahu [0,1]
 * @property-read float $realGreen Vrací zelenou složku vyjádřenou jako reálné číslo v rozsahu [0,1]
 * @property-read float $realBlue Vrací modrou složku vyjádřenou jako reálné číslo v rozsahu [0,1]
 * @property-read float $realAlpha Vrací alfa složku vyjádřenou jako reálné číslo v rozsahu [0,1]
 */
class Color extends Core\GObject {

    /**
     * @var int
     */
    private $red;

    /**
     * @var int
     */
    private $green;

    /**
     * @var int
     */
    private $blue;

    /**
     * @var int
     */
    private $alpha;

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     * @param int $alpha
     */
    public function __construct($red, $green, $blue, $alpha = 0) {
        $this->red = intval($red);
        $this->green = intval($green);
        $this->blue = intval($blue);
        $this->alpha = intval($alpha);
    }

    /**
     * @return int
     */
    public function getRed() {
        return $this->red;
    }

    /**
     * @return int
     */
    public function getGreen() {
        return $this->green;
    }

    /**
     * @return int
     */
    public function getBlue() {
        return $this->blue;
    }

    /**
     * @return int
     */
    public function getAlpha() {
        return $this->alpha;
    }

    /**
     * @param int $r
     */
    public function setRed($r) {
        $this->red = intval($r);
    }

    /**
     * @param int $g
     */
    public function setGreen($g) {
        $this->green = intval($g);
    }

    /**
     * @param int $b
     */
    public function setBlue($b) {
        $this->blue = intval($b);
    }

    /**
     * @param int $a
     */
    public function setAlpha($a) {
        $this->alpha = intval($a);
    }

    /**
     * Vrací červenou složku vyjádřenou jako reálné číslo v rozsahu [0,1]
     * @return float
     */
    public function getRealRed() {
        return $this->red / 255.0;
    }

    /**
     * Vrací zelenou složku vyjádřenou jako reálné číslo v rozsahu [0,1]
     * @return float
     */
    public function getRealGreen() {
        return $this->green / 255.0;
    }

    /**
     * Vrací modrou složku vyjádřenou jako reálné číslo v rozsahu [0,1]
     * @return float
     */
    public function getRealBlue() {
        return $this->blue / 255.0;
    }

    /**
     * Vrací alfa složku vyjádřenou jako reálné číslo v rozsahu [0,1]
     * @return float
     */
    public function getRealAlpha() {
        return $this->alpha / 255.0;
    }

    /**
     * Vrací barvu se změněnou průhledností.
     * @param int $alpha
     * @return \Iris\Base\Color
     */
    public function withAlpha($alpha) {
        $color = $this;
        $color->alpha = intval($alpha);
        return $color;
    }

    /**
     * Přimíchá zadanou barvu do aktuální v prostoru RGB. 
     * Quantity určuje množství přimíchané barvy. Hodnota 1.0 určuje stejné množství
     * 
     * @param \Iris\Base\Color $c
     * @param float $quantity
     * @return Color
     */
    public function mix(Color $c, $quantity = 1.0) {
        $new_r = (($this->red + $quantity * $c->red) / (1 + $quantity));
        $new_g = (($this->green + $quantity * $c->green) / (1 + $quantity));
        $new_b = (($this->blue + $quantity * $c->blue) / (1 + $quantity));
        $new_a = (($this->alpha + $quantity * $c->alpha) / (1 + $quantity));
        return new Color($new_r, $new_g, $new_b, $new_a);
    }

    /**
     * @param Color $color
     * @return boolean
     */
    public function equals(Core\GObject $color) {
        if($color instanceof $this)
            return ($this->red == $color->red) && 
                   ($this->green == $color->green) &&
                   ($this->blue == $color->blue) &&
                   ($this->alpha == $color->alpha);
        return false;
    }
    
    /**
     * Přičte k aktuální barvě zadanou.
     * @param Color $c
     * @return Color
     */
    final public function addition(Color $c){
        return new Color(Core\Math::min($this->red + $c->red, 255), 
                         Core\Math::min($this->green + $c->green, 255),
                         Core\Math::min($this->blue + $c->blue, 255),
                         Core\Math::min($this->alpha + $c->alpha, 255));
    }
    
    /**
     * Odečte od aktuální barvy zadanou.
     * @param Color $c
     * @return Color
     */
    final public function subtraction(Color $c){
        return new Color(Core\Math::max($this->red - $c->red, 0), 
                         Core\Math::max($this->green - $c->green, 0),
                         Core\Math::max($this->blue - $c->blue, 0),
                         Core\Math::max($this->alpha - $c->alpha, 0));
    }
    
    /**
     * Vynásobí aktuální barvu zadanou.
     * @param Color $c
     * @return Color
     */
    final public function multiplication(Color $c){
        return new Color($this->red * $c->red / 255, 
                         $this->green * $c->green / 255,
                         $this->blue * $c->blue / 255,
                         $this->alpha * $c->alpha / 255);        
    }
    
    /**
     * Vrací hexadecimální reprezentaci barvy
     * @return string
     */
    public function toString() {
        return sprintf("%X%X%X%X", $this->red, $this->green, $this->blue, $this->alpha);
    }

    /**
     * Parsuje html reprezentaci barvy do RGB prostoru.
     * @param string $hex
     * @param int $opacity
     * @return Color
     */
    public static function parse($hex, $opacity = 0) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return new Color($r, $g, $b);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function red() {
        return new Color(255, 0, 0);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function green() {
        return new Color(0, 255, 0);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function blue() {
        return new Color(0, 0, 255);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function white() {
        return new Color(255, 255, 255);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function black() {
        return new Color(0, 0, 0);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function magenta() {
        return new Color(255, 0, 255);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function cyan() {
        return new Color(0, 255, 255);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function yellow() {
        return new Color(255, 255, 0);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function gray() {
        return new Color(128, 128, 128);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function darkGrey() {
        return new Color(64, 64, 64);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function lightColor() {
        return new Color(192, 192, 192);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function orange() {
        return new Color(255, 165, 0);
    }

    /**
     * @return \Iris\Base\Color
     */
    final public static function brown() {
        return new Color(165, 42, 42);
    }

    /**
     * Prázdná barva (plně průhledná bílá).
     * @return \Iris\Base\Color
     */
    final public static function emptyColor() {
        return new Color(0, 0, 0, 0);
    }
}