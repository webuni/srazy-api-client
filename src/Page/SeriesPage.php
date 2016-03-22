<?php

/*
 * This is part of the webuni/srazy-api-client.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\Srazy\Page;

use Doctrine\Common\Collections\ArrayCollection;
use Webuni\Srazy\Crawler;
use Webuni\Srazy\Model\Event;
use Webuni\Srazy\Model\Series;

class SeriesPage extends AbstractPage
{
    private static $months = [1 => 'led', 'úno', 'bře', 'dub', 'kvě', 'črv', 'čvc', 'srp', 'zář', 'říj', 'lis', 'pro'];

    public function getSeries()
    {
        $uri = preg_replace('~/terminy/?$~', '', $this->crawler->getUri());

        $series = $this->client->model(Series::class, $uri);

        $series->setUri($uri);
        $series->setName(trim($this->crawler->filter('.event-wrap h1.event-title')->text()));
        $series->setDescription(trim($this->crawler->filter('.event-wrap .event-desc .event-desc-inner')->html()));

        $this->getEvents($series);

        return $series;
    }

    public function getEvents(Series $series)
    {
        $events = $this->crawler->filter('.event-main .row .row')->each(function (Crawler $row) use ($series) {
            $uri = $row->filter('h4 a')->link()->getUri();
            $event = $this->client->model(Event::class, $uri);
            $event->setSeries($series);

            $event->setUri($uri);
            $event->setName(trim($row->filter('h4 a')->text()));

            $day = trim($row->filter('.datelist-day')->text());
            $month = self::convertMonth(trim($row->filter('.datelist-month')->text()));
            $year = trim($row->filter('.datelist-year')->text());

            $event->setStart(new \DateTime(sprintf('%d-%d-%d', $day, $month, $year), new \DateTimeZone('Europe/Prague')));

            return $event;
        });

        $events = new ArrayCollection($events);
        $series->setEvents($events);

        return $events;
    }

    private static function convertMonth($month)
    {
        return array_search($month, self::$months, true);
    }
}
