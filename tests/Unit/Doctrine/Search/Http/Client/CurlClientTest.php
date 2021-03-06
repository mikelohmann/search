<?php
namespace Unit\Doctrine\Search\Http\Client;

use Doctrine\Search\Http\Client\CurlClient;

/**
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class CurlClientTest extends \PHPUnit_Framework_TestCase
{

    public function testCallExistHostWithMethodGet()
    {
        $client = new CurlClient('http://www.google.de/');
        $response = $client->sendRequest();
        $this->assertTrue($response->isSuccessfull());
        $this->assertEquals('GET', $response->getHeader('method'));
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @expectedException \Exception
     */
    public function testCallNonExististingHostWithMethodGet()
    {
        $client = new CurlClient('http://www/');
        $response = $client->sendRequest();
        $this->assertTrue($response->isSuccessfull());
        $this->assertEquals('GET', $response->getHeader('method'));
        $this->assertEquals(200, $response->getStatusCode());
    }
}
