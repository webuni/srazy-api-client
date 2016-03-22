<?php

namespace Webuni\Srazy\Tests\Page;

use Webuni\Srazy\Model\Series;
use Webuni\Srazy\Page\SeriesPage;

class SeriesPageTest extends AbstractPageTest
{
    public function testGetSeries()
    {
        $page = $this->createPage(SeriesPage::class, file_get_contents(__DIR__.'/fixtures/lambda-series.html'));
        $series = $page->getSeries();

        $this->assertEquals('Lambda Meetup Ostrava', $series->getName());
        //$this->assertEquals('http://srazy.info/lambda-meetup-ostrava', $series->getUri());
    }

    public function testGetEvents()
    {
        $page = $this->createPage(SeriesPage::class, file_get_contents(__DIR__.'/fixtures/lambda-series.html'));
        $events = $page->getEvents(new Series());

        $this->assertEquals(
            ['LambdaOva 5 - Elm, Redux', 'http://srazy.info/lambda-meetup-ostrava/6231', new \DateTime('2016-03-02', new \DateTimeZone('Europe/Prague'))],
            [$events[0]->getName(), $events[0]->getUri(), $events[0]->getStart()]
        );
        $this->assertEquals(
            ['LamdaOva 4 - React!', 'http://srazy.info/lambda-meetup-ostrava/4389', new \DateTime('2014-03-24', new \DateTimeZone('Europe/Prague'))],
            [$events[1]->getName(), $events[1]->getUri(), $events[1]->getStart()]
        );
        $this->assertEquals(
            ['pondělí', 'http://srazy.info/lambda-meetup-ostrava/3595', new \DateTime('2013-08-19', new \DateTimeZone('Europe/Prague'))],
            [$events[4]->getName(), $events[4]->getUri(), $events[4]->getStart()]
        );
    }
}
