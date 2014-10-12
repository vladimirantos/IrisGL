<?php

namespace Iris\Core;

/**
 * Třída umožňuje rychlé spojování řetězců.
 * @author Vladimír Antoš
 * @version 1.0
 */
final class StringBuilder {

    /**
     * @var string
     */
    private $value = null;

    /**
     * @param string $string
     */
    public function append($string) {
        $this->value = sprintf('%s%s', $this->value, $string);
    }

    /**
     * @param string $string
     * @param string $html
     */
    public function appendLine($string = "", $html = false) {
        if ($html) {
            $this->value = sprintf("%s%s%s", $this->value, '<br>', $string);
        } else {
            $this->value = sprintf("%s%s%s", $this->value, '\r\n', $string);
        }
    }

    /**
     * @param string $format
     */
    public function appendFormat($format) {
        $val = "";
        $function = '$val = sprintf($format';
        $written = false;
        $args = func_get_args();
        for ($i = 1; $i < count($args); $i++) {
            $function = sprintf("$function, %s[%s]", '$args', $i);
        }
        $function = sprintf("%s);", $function);
        eval($function);
        $this->append($val);
    }

    public function reset() {
        $this->value = null;
    }

    /**
     * @param string $value
     */
    public function set($value) {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString() {
        return $this->value;
    }

}