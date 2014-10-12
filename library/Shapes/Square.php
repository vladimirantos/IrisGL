<?php
namespace Iris\Shapes;

use \Iris\Base;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Square  extends Rectangle {

    /**
     * @var int
     */
    private $width;
    
    /**
     * @param Base\Position $leftTopCorner
     * @param int $width
     * @param Base\Color $c
     */
    public function __construct(Base\Position $leftTopCorner, $width, Base\Color $c) {
        parent::__construct($leftTopCorner, new Base\Position($leftTopCorner->x + $width, $leftTopCorner->y + $width), $c);
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getWidth(){
        return $this->width;
    }
    
}
