<?php

namespace Iris\Shapes;

use \Iris\Base;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Rectangle extends Base\Shape {

    /**
     * @var Base\Position
     */
    protected $leftTop;

    /**
     * @var Base\Position
     */
    protected $rightBottom;

    /**
     * @param Base\Position $leftTopCorner
     * @param Base\Position $rightBottomCorner
     * @param Base\Color $c
     */
    public function __construct(Base\Position $leftTopCorner, Base\Position $rightBottomCorner, Base\Color $c) {
        parent::__construct($c);
        $this->leftTop = $leftTopCorner;
        $this->rightBottom = $rightBottomCorner;
    }

    /**
     * @return Base\Position
     */
    public function getLeftTop() {
        return $this->leftTop;
    }

    /**
     * @return Base\Position
     */
    public function getRightBottom() {
        return $this->rightBottom;
    }

    /**
     * @return Base\Canvas
     */
    public function draw() {
        if ($this->isFilled)
            imagefilledrectangle($this->canvas->getCanvas(), $this->leftTop->X, 
                    $this->leftTop->Y, $this->rightBottom->X, $this->rightBottom->Y, $this->getAllocatedColor());
        else
            imagerectangle($this->canvas->getCanvas(), $this->leftTop->X, $this->leftTop->Y,
                    $this->rightBottom->X, $this->rightBottom->Y, $this->getAllocatedColor());
        return $this->canvas;
    }

}
