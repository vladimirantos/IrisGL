<?php

namespace Iris\Base;
use \Iris\Core;
/**
 * Třída usnadňující vytvoření plátna. Provádí veškerá základní nastavení.
 * @author Vladimír Antoš
 * @version 1.0
 */
class CanvasFactory {
    public function __construct() {
        throw new Core\StaticClassException;
    }
    
    /**
     * @param int $width
     * @param int $height
     * @return \Iris\Base\Canvas
     */
    public static function create($width, $height){
        $canvas = new Canvas($width, $height, Color::white());
        $canvas->setCanvasFormat(ContentTypes::Png());
        $canvas->setImageFormat(ImageTypes::Png());
        return $canvas;
    }
}