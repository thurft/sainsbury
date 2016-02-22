<?php

require_once "product.php";

class productTest extends \PHPUnit_Framework_TestCase
{
    public function testCanSetTitle()
    {
        $product = new product();
        $product->setTitle("testTitle");

        $this->assertEquals("testTitle", $product->getTitle());
    }

    public function testCanGetTitle()
    {
        $product = new product();
        $product->setTitle("testTitle");

        $this->assertEquals("testTitle", $product->getTitle());
    }

    public function testCanSetDescription()
    {
        $product = new product();
        $product->setDescription("testDescription");

        $this->assertEquals("testDescription", $product->getDescription());
    }

    public function testCanGetDescription()
    {
        $product = new product();
        $product->setDescription("testDescription");

        $this->assertEquals("testDescription", $product->getDescription());
    }

    public function testCanSetUnitPrice()
    {
        $product = new product();
        $product->setUnitPrice("3.50");

        $this->assertEquals("3.50", $product->getUnitPrice());
    }

    public function testCanGetUnitPrice()
    {
        $product = new product();
        $product->setUnitPrice("3.50");

        $this->assertEquals("3.50", $product->getUnitPrice());
    }

    public function testCanSetSize()
    {
        $product = new product();
        $product->setSize("500kb");

        $this->assertEquals("500kb", $product->getSize());
    }

    public function testCanGetSize()
    {
        $product = new product();
        $product->setSize("500kb");

        $this->assertEquals("500kb", $product->getSize());
    }

}