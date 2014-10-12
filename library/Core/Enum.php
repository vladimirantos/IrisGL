<?php

namespace Iris\Core;

/**
 * Třída umožňuje vytváření výčtových typů.
 * @author Vladimír Antoš
 * @version 1.0
 */
abstract class Enum extends GObject {

    private $const = null;

    /**
     * @param string $value
     */
    public function __construct($value) {
        $this->const = $value;
    }

    /**
     * @param string $name
     * @param string $arguments
     * @return \Core\class
     */
    public static function __callStatic($name, $arguments) {
        $class = get_called_class();
        $const = constant("$class::$name");
        return new $class($const);
    }

    /**
     * Určuje jestli se hodnota výčtového typu rovná zadanému.
     * @param \Core\Enum $enum
     * @return bool
     * @override Object
     */
    public function equals(GObject $enum) {
        if($enum instanceof Enum)
            return $this->const == $enum->const;
        return false;
    }

    /**
     * Určuje jestli existuje zadaná hodnota výčtového typu.
     * @param string $value
     * @return bool
     */
    final public function isDefined($value) {
        $class = get_called_class();
        return defined("$class::$value");
    }

    /**
     * @return string
     * @override Object
     */
    public function toString() {
        return (string) $this->const;
    }

}
