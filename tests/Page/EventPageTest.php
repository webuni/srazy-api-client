<?php

namespace Webuni\Srazy\Tests\Page;

use Webuni\Srazy\Page\EventPage;

class EventPageTest extends AbstractPageTest
{
    public function testGetEvent()
    {
        $page = $this->createPage(EventPage::class, file_get_contents(__DIR__.'/fixtures/posledni-sobota-event.html'));
        $event = $page->getEvent();

        $this->assertEquals('Brno 2016 - Rychlost', $event->getName());
        $this->assertEquals('Božetěchova 1, Brno', $event->getAddress());
        $this->assertContains('Tripomatic', $event->getDescription());

        $comments = $event->getComments();
        $this->assertCount(6, $comments);
        $this->assertEquals('2016-02-17T12:40:00+0100', $comments[1]->getDate()->format(\DateTime::ISO8601));
        $this->assertEquals('Honza Černý chemiX', $comments[1]->getAuthor()->getName());
        $this->assertContains('Navíc hype barcampů už je dávno pryč', $comments[1]->getText());
    }
}
