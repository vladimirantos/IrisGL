<?php

namespace Iris\Core;

/**
 * Obsahuje pomocné matematické funkce.
 * @author Vladimír Antoš
 * @version 1.0
 */
final class Math extends GObject {

    public function __construct() {
        throw new StaticClassException;
    }
    
    /**
     * Rozhodne jestli je zadané číslo liché.
     * @param int $number
     * @return bool
     */
    final public static function isOddNumber($number) {
        return $number % 2;
    }

    /**
     * @param float $value
     * @return float
     */
    final public static function sqrt($value){
        return sqrt($value);
    }
    
    /**
     * @param float $value
     * @return float
     */
    final public static function abs($value){
        return abs($value);
    }
    
    /**
     * @return mixed
     */
    final public static function min(){
        return call_user_func_array("min", func_get_args());
    }
    
    final public static function max(){
        return call_user_func_array("max", func_get_args());
    }
}
