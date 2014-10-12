<?php

namespace Iris\Base;

use \Iris\Core;

/**
 * Reprezentace vektoru ve 2D prostoru
 * @author Vladimír Antoš
 * @version 1.0
 * @property float $X
 * @property float $Y
 */
class Vector extends Core\GObject {

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
     * @return \Iris\Base\Vector
     */
    public function setX($x) {
        $this->x = floatval($x);
        return $this;
    }

    /**
     * @param float $y
     * @return \Iris\Base\Vector
     */
    public function setY($y) {
        $this->y = floatval($y);
        return $this;
    }

    /**
     * Velikost vektoru
     * @return float
     */
    public function length() {
        return \Iris\Core\Math::sqrt($this->x * $this->x + $this->y * $this->y);
    }

    /**
     * Skalární násobení vektorů, nebo násobit vektor skalárem.
     * @param \Iris\Base\Vector|float $value
     * @return \Iris\Base\Vector
     * @throws \Nette\InvalidArgumentException
     */
    public function multiplication($value) {
        if ($value instanceof Vector) {
            //skalární násobení vektorů
            return $this->x * $value->x + $this->y * $value->y;
        }
        if (is_float($value)) {
            //násobení vektoru skalárem
            return new Vector($value * $this->x, $value * $this->y);
        }
        throw new \Nette\InvalidArgumentException("This argument must be Vector or scalar");
    }

    /**
     * Sečte dva vektory
     * @param \Iris\Base\Vector $v
     * @return \Iris\Base\Vector
     */
    public function addition(Vector $v){
        return new Vector($this->x + $v->x, $this->y + $v->y);
    }
    
    /**
     * Odečte dva vektory
     * @param \Iris\Base\Vector $v
     * @return \Iris\Base\Vector
     */
    public function subtraction(Vector $v){
        return new Vector($this->x - $v->x, $this->y - $v->y);
    }
    
    /**
     * Vrací opačný vektor
     * @return \Iris\Base\Vector
     */
    public function opposite() {
        return new Vector(-1.0 * $this->x, -1.0 * $this->y);
    }

    /**
     * Kontroluje jestli se dva vektory rovnají na okolí bodu s přesností 1e-6
     * @param \Iris\Core\GObject $obj
     * @return boolean
     */
    public function equals(Core\GObject $obj) {
        if ($obj instanceof Vector)
            return Core\Math::abs($this->x - $obj->x) < 1e-6 &&
                    Core\Math::abs($this->y - $obj->y) < 1e-6;
        return false;
    }

    /**
     * Zjistí jestli jsou vektory lineárně závislé
     * @param \Iris\Base\Vector $v
     * @return bool
     */
    public function linearlyIndependent(Vector $v){
        return Core\Math::abs(1 - $this->x * $v->Y/($this->y*$v->x)) > 1e6;
    }
    
    /**
     * @return string
     */
    public function toString() {
        return sprintf("(%s, %s)", $this->x, $this->y);
    }
    
    /**
     * Vrací nulový vektor.
     * @return \Iris\Base\Vector
     */
    public static function nullVector() {
        return new Vector(0.0, 0.0);
    }

}
