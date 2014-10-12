<?php

namespace Iris\Shapes;

use \Iris\Base;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Triangle extends Polygon{
    
    /**
     * @var Base\Position
     */
    private $p1;
 
    /**
     * @var Base\Position
     */
    private $p2;
    
    /**
     * @var Base\Position
     */
    private $p3;    
    
    /**
     * @param \Iris\Base\Position $p1
     * @param \Iris\Base\Position $p2
     * @param \Iris\Base\Position $p3
     * @param \Iris\Base\Color $c
     */
    public function __construct(Base\Position $p1, Base\Position $p2, Base\Position $p3, Base\Color $c) {
        parent::__construct($c);
        $this->addPosition($p1)->addPosition($p2)->addPosition($p3);
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->p3 = $p3;
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
     * @return Base\Position
     */
    public function getP3() {
        return $this->p3;
    }
}