<?php

namespace Iris\Shapes;

use \Iris\Base;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Polygon extends Base\Shape {

    /**
     * @var Base\Position[]
     */
    protected $positions;

    /**
     * @param Color $c
     */
    public function __construct(Base\Color $c) {
        parent::__construct($c);
    }

    /**
     * @param int $index
     * @return Base\Position
     * @throws \Iris\Core\OutOfRangeException
     */
    public function __get($index) {
        if (!isset($this->positions[$index]))
            throw new \Iris\Core\OutOfRangeException("Index " . $index . " is out of range");
        return $this->positions[$index];
    }

    /**
     * @param Base\Position $p
     * @return Polygon
     */
    public function addPosition(Base\Position $p) {
        $this->positions[] = $p->x;
        $this->positions[] = $p->y;
        return $this;
    }

    /**
     * @return Base\Canvas
     */
    public function draw() {
        if ($this->isFilled)
            imagefilledpolygon($this->canvas->getCanvas(), $this->positions, 
                    count($this->positions) / 2, $this->getAllocatedColor());
        else
            imagepolygon($this->canvas->getCanvas(), $this->positions, 
                    count($this->positions) / 2, $this->getAllocatedColor());
        return $this->canvas;
    }

}
