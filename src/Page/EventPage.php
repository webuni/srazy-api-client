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
use Webuni\Srazy\Model\Comment;
use Webuni\Srazy\Model\Event;
use Webuni\Srazy\Model\Series;
use Webuni\Srazy\Model\Session;
use Webuni\Srazy\Model\User;

class EventPage extends AbstractPage
{
    public function getSeries()
    {
        $uri = $this->crawler->getUri();

        $series = $this->client->model(Series::class, $uri);
        $series->setUri($uri);
        $series->setName(trim($this->crawler->filter('h1.event-title')->text()));
        $series->setDescription(trim($this->crawler->filter('.event-header .event-desc-inner')->html()));

        return $series;
    }

    public function getEvent()
    {
        $uri = $this->crawler->getUri();
        /* @var $event Event */
        $event = $this->client->model(Event::class, $uri);

        $name = $this->crawler->filter('h2.date-title');
        if (!count($name)) {
            $name = $this->crawler->filter('h1.event-title');
        }

        $startNode = $this->crawler->filter('time.dtstart');
        $placeNode = $this->crawler->filter('.event-location-name');

        if (!$startNode->isEmpty()) {
            $event->setStart(new \DateTime($startNode->attr('datetime'), new \DateTimeZone('Europe/Prague')));
        }

        if (!$placeNode->isEmpty()) {
            $event->setLocation($placeNode->croppedText());
            $event->setMapUrl($this->crawler->filter('.pull-left h3.event-dateplace a')->link()->getUri());
            $event->setAddress($this->crawler->filter('span[itemprop="address"]')->text());
        }

        $event->setName($name->text());

        $description = '';
        /* @var $node \DOMElement */
        foreach ($this->crawler->filter('#snippet--attending ~ hr')->nextAll() as $node) {
            if ('hr' === $node->nodeName) {
                break;
            }

            $description .= $node->ownerDocument->saveHTML($node);
        }

        $event->setDescription($description);
        $event->setSessions($this->getSessions($event));
        $event->setComments($this->getComments($event));

        return $event;
    }

    public function getSessions(Event $event)
    {
        $sessions = new ArrayCollection();

        $this->crawler->filter('#snippet--program dt')->each(function (Crawler $dt) use ($sessions, $event) {
            $session = new Session();
            $session->setEvent($event);

            $time = new \DateTime($dt->text(), new \DateTimeZone('Europe/Prague'));
            $date = clone $event->getStart();
            $date->setTime($time->format('H'), $time->format('i'), $time->format('s'));

            $session->setStart($date);
            if ($previousSession = $sessions->last()) {
                $previousSession->setStop($date);
            }

            $sessions->add($session);
        });

        $this->crawler->filter('#snippet--program dd')->each(function (Crawler $dd, $i) use ($sessions) {
            $session = $sessions[$i];
            if (preg_match('/program-type-([^ ]+)/', $dd->attr('class'), $matches)) {
                $session->setType($matches[1]);
            }

            $title = $dd->filter('.program-title');
            $speaker = $dd->filter('.program-speaker');
            $description = $dd->filter('.program-desc');

            if (count($title)) {
                $session->setTitle(trim($title->text()));
            }
            if (count($speaker)) {
                $session->setSpeaker(trim($speaker->text()));
            }
            if (count($description)) {
                $session->setDescription(trim($description->text()));
            }
        });

        return $sessions;
    }

    public function getComments($event)
    {
        $comments = $this->crawler->filter('.comments .comment')->each(function (Crawler $node) use ($event) {
            $date = trim($node->filter('.comment-date')->text());
            $date = \DateTime::createFromFormat('d. m. Y v H:i', $date, new \DateTimeZone('Europe/Prague'));

            $authorNode = $node->filter('.comment-name');
            $authorUri = $authorNode->link()->getUri();

            $author = $this->client->model(User::class, $authorUri);
            $author->setUri($authorUri);
            $author->setName(trim($authorNode->text()));

            $text = '';
            if (preg_match('/<\\/b>:(.+?)<p class="comment-footer/is', $node->filter('.comment-bubble')->html(), $matches)) {
                $text = trim($matches[1]);
            }

            $comment = new Comment();
            $comment->setEvent($event);
            $comment->setDate($date);
            $comment->setAuthor($author);
            $comment->setText($text);

            return $comment;
        });

        return new ArrayCollection(array_reverse($comments));
    }
}
