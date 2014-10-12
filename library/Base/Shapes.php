<?php

namespace Iris\Base;

use \Iris\Core;

/**
 * Základní rozhraní všech objektů. Každý objekt je definován svou barvou a schopností vykreslit se.
 * Také musí umět na sobě zobrazovat další objekty. Pokud je nějaký objekt zanořen, stává se potomkem aktuálního
 * a přebírá od něj jeho vlastnosti (rozměry, barvu, výplň). Důležité jsou rozměry, vnořený objekt již nepracuje
 * v rozměrech canvasu ale v rozměrech svého předka.
 */
interface IShape extends ICanvasObjects {
    
    /**
     * Nastaví objektu plochu na které se má zobrazit.
     * @param \Iris\Base\Canvas $canvas
     */
    function setCanvas(Canvas $canvas);
    
    /**
     * Metoda pro vnoření objektů.
     * @param \Iris\Base\IShape $shape
     */
    function addShape(IShape $shape);
    
    /**
     * @return bool
     */
    function hasShapes();
    
    /**
     * @return IShape[]
     */
    function getShapes();
    
    /**
     * @return Canvas
     */
    function draw();
}

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
abstract class Shape extends Core\GObject implements IShape {

    /**
     * @var Canvas
     */
    protected $canvas;

    /**
     * @var bool
     */
    protected $isFilled;
    
    /**
     * @var Color
     */
    protected $color;

    /**
     * Pole vnitřních objektů daného IShape
     * @var IShape[]
     */
    private $shapes = array();
    
    /**
     * @param \Iris\Base\Color $c
     */
    public function __construct(Color $c) {
        $this->color = $c;
    }
    
    /**
     * @param Canvas $canvas
     * @return \Iris\Base\Shape
     */
    public function setCanvas(Canvas $canvas) {
        $this->canvas = $canvas;
        return $this;
    }
    
    /**
     * @return Canvas
     */
    public function getCanvas() {
        return $this->canvas;
    }

    /**
     * @param Color $c
     * @return \Iris\Base\Shape
     */
    public function setColor(Color $c) {
        $this->color = $c;
    }

    /**
     * @return Color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Vrací pole vnitřních objektů
     * @return IShape[]
     */
    public function getShapes(){
        return $this->shapes;
    }
    
    /**
     * @param bool $boolean
     * @return \Iris\Base\Shape
     */
    public function setIsFilled($boolean){
        $this->isFilled = $boolean;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function hasShapes(){
        return count($this->shapes) > 0;
    }
    
    /**
     * @param \Iris\Base\IShape $shape
     */
    public function addShape(IShape $shape) {
        $this->shapes[] = $shape;
        return $this;
    }
    
    /**
     * @return resource
     */
    protected function getAllocatedColor(){
        return imagecolorallocatealpha($this->canvas->getCanvas(), $this->color->red, $this->color->green, $this->color->blue, $this->color->alpha);
    }
}