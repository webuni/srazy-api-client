<?php


namespace Webuni\Srazy\Tests;

use Webuni\Srazy\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var Client */
    private $client;

    protected function setUp()
    {
        $this->client = new Client();
    }

    public function testSeries()
    {
        $series = $this->client->series()->find('symfony');
        $this->assertGreaterThanOrEqual(5, $series->count());

        $first = $series->first();
        $this->assertContains('Brno', $first->getName());
        $this->assertEquals('http://srazy.info/symfony-brno', $first->getUri());
        $this->assertGreaterThanOrEqual(16, $first->getFollowers()->count());
        $this->assertContains('Brna', $series->first()->getDescription());
        $this->assertGreaterThanOrEqual(8, $first->getEvents()->count());
    }
}
