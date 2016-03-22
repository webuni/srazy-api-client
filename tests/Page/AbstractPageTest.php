<?php

namespace Webuni\Srazy\Tests\Page;

use Webuni\Srazy\Client;
use Webuni\Srazy\Crawler;

abstract class AbstractPageTest extends \PHPUnit_Framework_TestCase
{
    protected function createPage($class, $html)
    {
        $client = new Client();
        $crawler = new Crawler(null, null, 'http://srazy.info');
        $crawler->addHtmlContent($html);

        return new $class($crawler, $client);
    }
}
