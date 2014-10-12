<?php

namespace Iris\Shapes;

use \Iris\Base;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Ellipse extends Base\Shape {

    /**
     * @var Base\Position
     */
    protected $center;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @param \Iris\Base\Position $center
     * @param int $width
     * @param int $height
     * @param \Iris\Base\Color $c
     */
    public function __construct(Base\Position $center, $width, $height, Base\Color $c) {
        parent::__construct($c);
        $this->center = $center;
        $this->width = $width;
        $this->height = $height;
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
    public function getWidth() {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @return Base\Canvas
     */
    public function draw() {
        if ($this->isFilled)
            imagefilledellipse($this->canvas->getCanvas(), $this->center->X, 
                    $this->center->Y, $this->width, $this->height, $this->getAllocatedColor());
        else
            imageellipse($this->canvas->getCanvas(), $this->center->X, $this->center->Y, 
                    $this->width, $this->height, $this->getAllocatedColor());
        return $this->canvas;
    }

}
