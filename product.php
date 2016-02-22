<?php
/**
 * Created by IntelliJ IDEA.
 * User: jonathanmoreirazuvic
 * Date: 19/02/16
 * Time: 18:12
 */


class Product
{
    public $title, $size, $unit_price, $description;

    public function getTitle() {
        return !empty($this->title) ? $this->title : NULL;
    }

    public function getSize() {
        return !empty($this->size) ? $this->size : NULL;
    }

    public function getUnitPrice() {
        return !empty($this->unit_price) ? $this->unit_price : NULL;
    }

    public function getDescription() {
        return !empty($this->description) ? $this->description : NULL;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
    public function setSize($size) {
        $this->size = $size;
    }
    public function setUnitPrice($unitPrice) {
        $this->unit_price = $unitPrice;
    }
    public function setDescription($description) {
        $this->description = $description;
    }

}