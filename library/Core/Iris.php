<?php

namespace Iris\Base;
use \Iris\Core;

/**
 * Obecné informace o IrisGL Frameworku.
 * @author Vladimír Antoš
 * @version 1.0
 */
class Iris {
    
    const Name = "IrisGL Framework";
    
    const Version = "1.0 Beta";
    
    const Build = 11409;
    
    public function __construct() {
        throw new Core\StaticClassException;
    }
    
    /**
     * Kontroluje, jestli je možné použít framework Iris
     * @return bool
     */
    public static function isAvailable(){
        return function_exists("gd_info");
    }
    
    /**
     * Vrací informace o prostředí GD
     * @return array
     */
    public static function gdEnvironment(){
        return gd_info();
    }
}