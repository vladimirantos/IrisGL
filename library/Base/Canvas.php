<?php

namespace Iris\Base;

use \Iris\Core;

/**
 * Společné rozhraní pro objekty, které se zobrazují na plátně.
 */
interface ICanvasObjects {

    /**
     * Nastaví objektu plátno, na které se má vykreslit.
     * @param \Iris\Base\Canvas $canvas
     */
    function setCanvas(Canvas $canvas);

    /**
     * Plátno na kterém je zobrazen.
     * @return Canvas
     */
    function getCanvas();
}

/**
 * Určuje typy souborů podporované IrisGL
 */
class ImageTypes extends Core\Enum {

    const Png = "png";
    const Jpg = "jpg";
    const Jpeg = "jpeg";
    const Gif = "gif";

}

/**
 * Určuje typ obsahu pro funkci header - header(Content-type: image/png)
 */
class ContentTypes extends Core\Enum {

    const Png = "image/png";
    const Jpg = "image/jpg";
    const Gif = "image/gif";

}

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class Canvas extends Core\GObject implements \ArrayAccess {

    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var IShape[]
     */
    private $objects = array();

    /**
     * @var resource
     */
    private $canvas;

    /**
     * @var Color
     */
    private $bgColor;

    /**
     * Určuje v jakém formátu bude obrázek uložen.
     * @var ImageTypes
     */
    private $imageFormat;

    /**
     * Určuje v jakém formátu bude plátno zobrazováno na stránce (při volání metody show())
     * @var ContentTypes
     */
    private $canvasType;

    /**
     * Nastaví kde bude plátno na stránce umístěno. Určuje souřadnice středu plátna.
     * @var Position
     */
    private $canvasPosition;

    /**
     * @param int $width
     * @param int $height
     * @param \Iris\Base\Color $backgroundColor
     */
    public function __construct($width, $height, Color $backgroundColor = null) {
        $this->width = intval($width);
        $this->height = intval($height);
        $this->bgColor = $backgroundColor;
        $this->imageFormat = ImageTypes::Png();
        $this->create();
    }

    /**
     * Nastaví barvu pozadí plátna.
     * @param \Iris\Base\Color $c
     */
    public function setBackgroundColor(Color $c) {
        $this->bgColor = $c;
    }

    /**
     * Nastavuje v jakém formátu bude plátno zobrazeno při volání metody show.
     * @param \Iris\Base\ContentTypes $t
     */
    public function setCanvasFormat(ContentTypes $t) {
        $this->canvasType = $t;
    }

    /**
     * Nastavuje v jakém formátu bude obrázek uložen.
     * @param \Iris\Base\ImageTypes $t
     */
    public function setImageFormat(ImageTypes $t) {
        $this->imageFormat = $t;
    }

    /**
     * Nastavuje kde bude na stránce plátno umístěno.
     * @param \Iris\Base\Position $p Souřadnice středu plátna
     */
    public function setCanvasPosition(Position $p) {
        $this->canvasPosition = $p;
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
     * @return resource
     */
    public function getCanvas() {
        return $this->canvas;
    }

    /**
     * Přidá objekt na plátno.
     * @param IShape $shape
     * @return \Iris\Base\Canvas
     */
    public function addShape(IShape $shape) {
        $this->objects[] = $shape->setCanvas($this);
        if ($shape->hasShapes()) {
            array_map(function($shape) {
                $shape->setCanvas($this);
                $this->objects[] = $shape;
            }, $shape->getShapes());
        }
        return $this;
    }

    /**
     * @param \Iris\Base\Image $image
     * @return \Iris\Base\Canvas
     */
    public function fromImage(Image $image) {
        imagecreatefromgd($image->path);
        return $this;
    }

    public function toImage() {
        
    }

    /**
     * Zobrazí obrázek na stránce. Nastavuje Content-type na image.
     */
    public function show() {
        $this->drawShapes();
        header("Content-type: " . $this->canvasType);
        switch ($this->imageFormat) {
            case ImageTypes::Png: imagepng($this->canvas);
                break;
            case ImageTypes::Jpg: imagejpeg($this->canvas);
                break;
            case ImageTypes::Jpeg: imagejpeg($this->canvas);
                break;
            case ImageTypes::Gif: imagegif($this->canvas);
            default:
                break;
        }
    }

    /**
     * @param string $path
     */
    public function save($path) {
        switch ($this->imageFormat) {
            case ImageTypes::Png: imagepng($this->canvas, $path);
                break;
            case ImageTypes::Jpg: imagejpeg($this->canvas, $path);
                break;
            case ImageTypes::Jpeg: imagejpeg($this->canvas, $path);
                break;
            case ImageTypes::Gif: imagegif($this->canvas, $path);
            default:return;
                break;
        }
    }

    /**
     * @return int
     */
    public function countObjects() {
        return count($this->objects);
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->objects);
    }

    /**
     * @param int $offset
     * @return ICanvasObjects
     */
    public function offsetGet($offset) {
        return $this->offsetExists($offset) ? $this->objects[$offset] : NULL;
    }

    /**
     * @param int $offset
     * @param ICanvasObjects $value
     */
    public function offsetSet($offset, $value) {
        $this->addShape($value);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset) {
        if ($this->offsetExists($offset))
            unset($this->objects[$offset]);
    }

    /**
     * Vytvoří základní obrázek plátna se zadanou barvou.
     */
    private function create() {
        $this->canvas = imagecreatetruecolor($this->width, $this->height);
        imagecolorallocate($this->canvas, $this->bgColor->red, $this->bgColor->blue, $this->bgColor->green);
    }

    private function drawShapes() {
        foreach ($this->objects as $shape)
            $shape->draw();
    }

}
