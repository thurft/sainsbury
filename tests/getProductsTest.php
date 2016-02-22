<?php

require_once "getProducts.php";

class GetProductsTest extends \PHPUnit_Framework_TestCase
{
    private $_siteURL = "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html";

    public function testCanCreateClass()
    {
        $start = new GetProducts();
        $this->assertInstanceOf('GetProducts', $start);
    }

    public function testCheckIfElementExists()
    {
        $start = new GetProducts();
        $crawler = $start->connectToSiteURL($this->_siteURL);
        $node = $crawler->filterXPath("//ul[contains(@class,'productLister') and contains(@class,'listView')] //li //h3 //a");
        $this->assertEquals(7,$node->count());
    }

    public function testCheckIfElementDoesNotExists()
    {
        $start = new GetProducts();
        $crawler = $start->connectToSiteURL($this->_siteURL);
        $this->setExpectedException('Exception');
        $start->checkElementExists($crawler, "//ul[contains(@class,'productdsdLister') ]");
    }

}