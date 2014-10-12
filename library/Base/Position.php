<?php

namespace Iris\Base;

use \Iris\Core;

/**
 * Reprezentace souřadnic ve 2D prostoru.
 * @author Vladimír Antoš
 * @version 1.0
 * @property float $X
 * @property float $Y
 */
class Position extends \Iris\Core\GObject {

    /**
     * @var float
     */
    private $x;

    /**
     * @var float
     */
    private $y;

    /**
     * @param float $x
     * @param float $y
     */
    public function __construct($x, $y) {
        $this->x = floatval($x);
        $this->y = floatval($y);
    }

    /**
     * @return float
     */
    public function getX() {
        return $this->x;
    }

    /**
     * @return float
     */
    public function getY() {
        return $this->y;
    }

    /**
     * @param float $x
     * @return \Iris\Base\Position
     */
    public function setX($x) {
        $this->x = floatval($x);
        return $this;
    }

    /**
     * @param float $y
     * @return \Iris\Base\Position
     */
    public function setY($y) {
        $this->y = floatval($y);
        return $this;
    }

    /**
     * @param \Iris\Base\Position $p
     * @return float
     */
    public function distance(Position $p) {
        return Core\Math::sqrt(($this->x - $p->x) * ($this->x - $p->x) +
                        ($this->y - $p->y) * ($this->y - $p->y));
    }
    
    /**
     * Posunutí pozice ve směru dx a dy
     * @param float $dx
     * @param float $dy
     * @return Position
     */
    public function shiftBy($dx, $dy) {
        return new Position($this->x + $dx, $this->y + $dy);
    }

    /**
     * Ověří zda je bod uvnitř obdélníku určeného levým horním a pravým dolním rohem
     * @param \Iris\Base\Position $leftTop
     * @param \Iris\Base\Position $rightButton
     * @return bool
     */
    public function isInside(Position $leftTop, Position $rightButton) {
        return $this->x >= $leftTop->x && $this->x <= $rightButton->x &&
                $this->y >= $leftTop->y && $this->y <= $rightButton->y;
    }

    /**
     * Zjistí jestli se bod nachází vlevo od zadaného
     * @param \Iris\Base\Position $p
     * @return bool
     */
    public function IsLeftFrom(Position $p) {
        return $this->x < $p->x;
    }

    /**
     * Zjistí jestli se bod nachází vpravo od zadaného
     * @param \Iris\Base\Position $p
     * @return bool
     */
    public function IsRightFrom(Position $p) {
        return $this->x > $p->x;
    }

    /**
     * Zjistí jestli se bod nachází nad zadaným
     * @param \Iris\Base\Position $p
     * @return bool
     */
    public function isAbove(Position $p) {
        return $this->y < $p->y;
    }

    /**
     * Zjistí jestli se bod nachází pod zadaným
     * @param \Iris\Base\Position $p
     * @return bool
     */
    public function isBellow(Position $p) {
        return $this->y > $p->y;
    }

    /**
     * Přičtení vektoru k pozici
     * @param \Iris\Base\Vector $v
     * @return \Iris\Base\Position
     */
    public function addition(Vector $v) {
        return new Position($this->x + $v->X, $this->y + $v->y);
    }

    /**
     * Vektor z aktuální pozice do zadané
     * @param \Iris\Base\Position $p
     * @return \Iris\Base\Vector
     */
    public function subtraction(Position $p) {
        return new Vector($this->x - $p->y, $this->y - $p->y);
    }

    /**
     * Vrací úhel mezi dvěmi pozicemi.
     * @param \Iris\Base\Position $p
     * @return float
     */
    public function angle(Position $p) {
        $dx = ($p->x - $this->x);
        $dy = ($p->y - $this->y);
        $l = sqrt($dx * $dx + $dy * $dy);
        $v = rad2deg(asin(($this->y - $p->y) / $l));
        if ($dx < 0) {
            $v = 180 - $v;
        }
        return $v;
    }

    /**
     * Testuje jestli se dva body rovnají v delta okolí bodu s přesností 1e-6.
     * @param \Iris\Core\GObject $obj
     * @return boolean
     */
    public function equals(Core\GObject $obj) {
        if ($obj instanceof Position)
            return $this->_equals($obj);
        return false;
    }

    /**
     * @return string
     */
    public function getHashCode() {
        return base64_encode($this->x) ^ base64_encode($this->y);
    }

    /**
     * @return string
     */
    public function toString() {
        return sprintf("[%s, %s]", $this->x, $this->y);
    }

    /**
     * Počátek souřadnic
     * @return \Iris\Base\Position
     */
    public static function origin() {
        return new Position(0, 0);
    }

    /**
     * @param \Iris\Base\Position $p
     * @return boolean
     */
    private function _equals(Position $p) {
        return Core\Math::abs($this->x - $p->x) < 1e-6 && Core\Math::abs($this->y - $p->y) < 1e-6;
    }

}

class PositionsList extends Core\GObject implements \ArrayAccess {

    /**
     * @var Position[]
     */
    private $positions;

    public function __construct() {
        $this->positions = array();
    }

    public function add(Position $p) {
        
    }

    public function offsetExists($offset) {
        
    }

    public function offsetGet($offset) {
        
    }

    public function offsetSet($offset, $value) {
        
    }

    public function offsetUnset($offset) {
        
    }

}
