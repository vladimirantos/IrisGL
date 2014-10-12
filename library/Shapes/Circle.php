<?php

namespace Iris\Shapes;

use \Iris\Base;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Circle extends Base\Shape {

    /**
     * @var Base\Position
     */
    private $center;

    /**
     * @var int
     */
    private $radius;

    /**
     * @param \Iris\Base\Position $center
     * @param int $radius
     * @param \Iris\Base\Color $c
     */
    public function __construct(Base\Position $center, $radius, Base\Color $c) {
        parent::__construct($c);
        $this->center = $center;
        $this->radius = $radius;
    }

    /**
     * @return Base\Position
     */
    public function getCenter() {
        return $this->center;
    }

    /**
     * @return int
     */
    public function getRadius() {
        return $this->radius;
    }

    public function addShape(Base\IShape $shape) {
        
    }
    
    /**
     * @return Base\Canvas
     */
    public function draw() {
        if ($this->isFilled)
            imagefilledellipse($this->canvas->getCanvas(), $this->center->X, 
                    $this->center->Y, $this->radius, $this->radius, $this->getAllocatedColor());
        else
            imageellipse($this->canvas->getCanvas(), $this->center->X, 
                    $this->center->Y, $this->radius, $this->radius, $this->getAllocatedColor());
        return $this->canvas;
    }
}
