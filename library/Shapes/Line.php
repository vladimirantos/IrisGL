<?php

namespace Iris\Shapes;

use \Iris\Base;

/**
 * Určuje typ čáry.
 */
class LineTypes extends \Iris\Core\Enum {

    const Normal = 0x01;
    const Dashed = 0x02;

}

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Line extends Base\Shape {

    /**
     * @var Base\Position
     */
    private $p1;

    /**
     * @var Base\Position
     */
    private $p2;

    /**
     * @var LineTypes
     */
    private $lineType;

    /**
     * @param \Iris\Base\Position $p1
     * @param \Iris\Base\Position $p2
     * @param \Iris\Base\Color $c
     */
    public function __construct(Base\Position $p1, Base\Position $p2, Base\Color $c) {
        parent::__construct($c);
        $this->p1 = $p1;
        $this->p2 = $p2;
    }

    /**
     * @param LineTypes $type
     * @return Line
     */
    public function setLineType(LineTypes $type) {
        $this->lineType = $type;
        return $this;
    }

    /**
     * @return Base\Position
     */
    public function getP1() {
        return $this->p1;
    }

    /**
     * @return Base\Position
     */
    public function getP2() {
        return $this->p2;
    }

    /**
     * @return Base\Canvas
     */
    public function draw() {
        if ($this->lineType == LineTypes::Dashed())
            imagedashedline($this->canvas->getCanvas(), $this->p1->X, $this->p1->Y, $this->p2->X, $this->p2->Y, $this->getAllocatedColor());
        else
            imageline($this->canvas->getCanvas(), $this->p1->X, $this->p1->Y, $this->p2->X, $this->p2->Y, $this->getAllocatedColor());
        return $this->canvas;
    }

}
