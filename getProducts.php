<?php


include_once "vendor/autoload.php";
include_once "product.php";

use Goutte\Client;

class GetProducts
{
    private $_client, $_siteURL, $_xPathProductList, $_xPathProductDescription, $_xPathProductUnitPrice;

    function __construct()
    {
        $this->_client = new Client();
        // Page URL
        $this->_siteURL = "http://hiring-tests.s3-website-eu-west-1.amazonaws.com/2015_Developer_Scrape/5_products.html";
        //XPath to product links
        $this->_xPathProductList = '//ul[contains(@class,"productLister") and contains(@class,"listView")] //li //h3 //a';
        //XPath Product Description
        $this->_xPathProductDescription = '//h3[text()="Description"]/following-sibling::div[1]';
        //XPath Product Unit Price
        $this->_xPathProductUnitPrice = '//p[contains(@class, "pricePerUnit")]';
    }

    public function init()
    {
        try {
            $crawler = $this->connectToSiteURL($this->_siteURL);
            $this->checkElementExists($crawler,$this->_xPathProductList);
            $products = $this->getAllProducts($crawler);
            $this->createJSON($products);
            $finalArray = $this->createFinalArray($products);

            echo $this->createJSON($finalArray);

        } catch(Exception $e) {
            echo  $e->getMessage();
        }
    }

    /*
     * Connects to a Site URL
     * @param: STRING url
     * @return OBJECT crawler
     */
    public function connectToSiteURL($siteURL)
    {
        try{
            $crawler = $this->_client->request('GET', $siteURL);
            return $crawler;
        } catch(Exception $e) {
            echo  $e->getMessage();
        }
    }

    /*
     * Set the XPath to an element
     * @param OBJECT Crawler
     * @returns: BOOL or Exception
     */
    public function checkElementExists(Symfony\Component\DomCrawler\Crawler $crawler, $xPath)
    {
        $node = $crawler->filterXPath($xPath);
        if($node->count() >= 1)
        {
            return true;
        }
        throw new Exception("You might not be on the right page or the elements might have changed.");
    }

    /*
     * Get all Products
     * @param OBJECT crawler
     * @returns ARRAY products
     */
    public function getAllProducts($crawler)
    {
        $nodes = $crawler->filterXPath($this->_xPathProductList);
        if($nodes->count() == 0 )
        {
            throw new Exception("There are no products to list.");
        }

        $products = [];
        // Loop through the products
        foreach($nodes as $node)
        {
            $product = new product();
            $product->setTitle( trim($node->nodeValue) );

            // If i do strlen(file_get_contents($url)); I still get the same value
            $response = $this->_client->getInternalResponse();
            $sizeKB = $response->getHeader('Content-Length') * 8; // octets to Bytes
            $sizeKB = $sizeKB / 1024; // Bytes to KB
            $product->setSize($sizeKB ."kb");

            $href = $node->getAttribute('href');
            if(!empty($href))
            {
                $crawlerProductPage = $this->connectToSiteURL($href);
                unset($href);

                $this->checkElementExists($crawlerProductPage,$this->_xPathProductDescription);
                $productDescriptionNodes = $crawlerProductPage->filterXPath($this->_xPathProductDescription);

                foreach($productDescriptionNodes as $productDescriptionNode)
                {
                    $product->setDescription(trim($productDescriptionNode->nodeValue));
                }

                $this->checkElementExists($crawlerProductPage,$this->_xPathProductUnitPrice);
                $productPriceNodes = $crawlerProductPage->filterXPath($this->_xPathProductUnitPrice);
                foreach($productPriceNodes as $productPriceNode)
                {
                    $price = explode("/",$productPriceNode->nodeValue);
                    $product->setUnitPrice(explode("£",$price[0])[1]);
                }
            }
            $products[] = $product;
        }
        return $products;
    }

    /*
     * Creates the final array
     * @param ARRAY products objects
     * @returns ARRAY formatted final array
     */
    public function createFinalArray($products)
    {
        $total = 0;
        foreach($products as $product)
        {
            $total += $product->getUnitPrice();
        }
        return array("results" => $products , "total" => $total);
    }

    /*
     * Creates JSON
     *
     * @param ARRAY
     * @returns JSON
     */
    public function createJSON($products)
    {
        return json_encode($products, JSON_PRETTY_PRINT);
    }
}
