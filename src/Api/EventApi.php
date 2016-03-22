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

namespace Webuni\Srazy\Api;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Webuni\Srazy\Model\Event;
use Webuni\Srazy\Page\AttendeesPage;
use Webuni\Srazy\Page\EventPage;

class EventApi extends AbstractApi
{
    public function get($event)
    {
        $url = $event;
        if ($event instanceof Event) {
            $url = $event->getUri();
        }

        $crawler = $this->client->get($url);
        $page = new EventPage($crawler, $this->client);

        return $page->getEvent();
    }

    public function getConfirmedAttendees(Event $event)
    {
        $url = $event->getUri().'?what=yes&do=showAll';

        $crawler = $this->client->ajax($url, [], function ($response) {
            return $this->getAttendeesSnippet($response, 'snippet--visitorsallyes');
        });
        $page = new AttendeesPage($crawler, $this->client);

        $attendees = $page->getAttendees();
        $event->setConfirmedAttendees($attendees);

        return $attendees;
    }

    public function getUnconfirmedAttendees(Event $event)
    {
        $url = $event->getUri().'?what=maybe&do=showAll';

        $crawler = $this->client->ajax($url, [], function ($response) {
            return $this->getAttendeesSnippet($response, 'snippet--visitorsallmaybe');
        });
        $page = new AttendeesPage($crawler, $this->client);

        $attendees = $page->getAttendees();
        $event->setUnconfirmedAttendees($attendees);

        return $attendees;
    }

    private function getAttendeesSnippet(ResponseInterface $response, $key)
    {
        $json = json_decode((string) $response->getBody(), true);
        $html = '<html><head><meta charset="UTF-8"></head><body>'.$json['snippets'][$key].'</body></html>';

        return new Response($response->getStatusCode(), $response->getHeaders(), $html, $response->getProtocolVersion(), $response->getReasonPhrase());
    }
}
