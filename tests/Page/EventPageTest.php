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

        $polls = $event->getPolls();
        $this->assertCount(2, $polls);
        $this->assertEquals('Pivo', $polls[0]->getName());
        $this->assertEquals('Workshop (rychlost)', $polls[1]->getName());

        $this->assertEquals([
            'samosebou že jdu' => '13',
            "rozhodnu se na místě (a případně počítám s tím, že budu stát\nu stolu)" => '4',
        ], $polls->first()->getChoices());
    }
}
