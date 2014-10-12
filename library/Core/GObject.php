<?php

namespace Iris\Core;

/**
 * Porovnává zadaný objekt s aktuálním.
 * Vrací:
 *  -1 aktuální objekt větší než zadaný
 *   0 jsou si oba objekty rovny
 *   1 zadaný objekt je větší než aktuální
 */
interface IComparable{
    
    /**
     * @param \Iris\Core\GObject $obj
     * @return int
     */
    function compareTo(GObject $obj);
}

/**
 * Umožňuje vytvořit novou instanci třídy se stejnými hodnotami jako je existující.
 */
interface ICloneable{
    
    /**
     * @return GObject
     */
    function cloneObject();
}

/**
 * Umožňuje uvolnit objektu paměť.
 */
interface IDisposable{
    function dispose();
}

/**
 * Podpora serializace objektu.
 */
interface ISerializable{
    
    /**
     * @return string
     */
    function serialize();
    
    /**
     * @param string $string
     * @return GObject
     */
    function unserialize($string);
}

class IrisException extends \Exception{
    public function __construct($message, $code = null, $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

class StaticClassException extends IrisException {}

class OutOfRangeException extends IrisException {}

/**
 * Základní třída. Dovoluje objektům používat vlastnosti. 
 * Každá třída musí být potomkem Object.
 * @author Vladimír Antoš
 * @version 1.0
 */
abstract class GObject implements ICloneable, ISerializable{

    /**
     * Vrátí řetězec, který představuje aktuální objekt
     * @return string
     */
    public function toString() {
        return get_class($this);
    }

    /**
     * Metoda zjišťuje, jestli jsou objekty stejného typu (třídy).
     * @param GObject $obj
     * @return bool
     */
    public function equals(GObject $obj) {
        return $this == $obj;
    }

    /**
     * Metoda zjištuje, jestli jsou objekty stejné instance.
     * @param GObject $obj
     * @return bool
     */
    final public function instanceEquals(GObject $obj) {
        return $this === $obj;
    }

    /**
     * Vrací typ zadané proměnné. Pokud je proměnná neznámého typu, metoda vrací false.
     * @param mixed $var
     * @return string
     */
    final public function getObjectType($var) {
        if (is_array($var))
            return "array";
        if (is_bool($var))
            return "boolean";
        if (is_callable($var))
            return "function reference";
        if (is_float($var))
            return "float";
        if (is_int($var))
            return "integer";
        if (is_null($var))
            return "null";
        if (is_numeric($var))
            return "numeric";
        if (is_object($var))
            return "object";
        if (is_resource($var))
            return "resource";
        if (is_string($var))
            return "string";
        return null;
    }

    /**
     * Vrací hash hodnotu objektu.
     * @return string
     */
    public function getHashCode() {
        return spl_object_hash($this);
    }

    /**
     * 
     * @return GObject
     */
    public function cloneObject() {
        return new $this;
    }

    /**
     * @return string
     */
    public function serialize() {
        return serialize($this);
    }

    /**
     * @param string $string
     * @return GObject
     */
    public function unserialize($string) {
        return unserialize($string);
    }

    public function __set($name, $value) {
        if (method_exists($this, $MethodName = 'set' . $name)) {
            return $this->$MethodName($value);
        } else
            throw new \Exception("Call to undefined or private setter of property - " . $name);
    }

    public function __get($name) {
        if (method_exists($this, $MethodName = 'get' . $name))
            return $this->$MethodName();
        else
            throw new \Exception("Call to undefined or private getter of property - " . $name);
    }
    
    /** @return string */
    public function __toString() {
        return $this->toString();
    }

    /** @return GObject */
    public function __clone() {
        return $this->cloneObject();
    }

}

