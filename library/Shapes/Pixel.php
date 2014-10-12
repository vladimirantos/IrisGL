<?php

namespace Iris\Shapes;

use \Iris\Base;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Pixel extends Base\Shape {
    
    /**
     * @var Position
     */
    private $position;
    
    /**
     * @param Base\Position $p
     * @param Base\Color $c
     */
    public function __construct(Base\Position $p, Base\Color $c) {
        parent::__construct($c);
        $this->position = $p;
    }
    
    /**
     * @return Base\Position
     */
    public function getPosition(){
        return $this->position;
    }
    
    /**
     * @return Base\Canvas
     */
    public function draw() {
        imagesetpixel($this->canvas->getCanvas(), $this->position->x, $this->position->y, $this->getAllocatedColor());
        return $this->canvas;
    }

    
}
