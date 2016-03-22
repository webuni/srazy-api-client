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

use Doctrine\Common\Collections\ArrayCollection;
use Webuni\Srazy\Model\Series;
use Webuni\Srazy\Page\CommunityPage;
use Webuni\Srazy\Page\SearchPage;
use Webuni\Srazy\Page\SeriesPage;

class SeriesApi extends AbstractApi
{
    /**
     * @return Series[]|ArrayCollection
     */
    public function find($series)
    {
        $crawler = $this->client->get(sprintf('/hledat/?s=%s', urlencode($series)));
        $page = new SearchPage($crawler, $this->client);

        return $page->getSeries();
    }

    public function get($series)
    {
        $url = $series;
        if ($series instanceof Series) {
            $url = $series->getUri();
        }

        $crawler = $this->client->get($url.'/terminy');
        $page = new SeriesPage($crawler, $this->client);

        return $page->getSeries();
    }

    public function getFollowers(Series $series)
    {
        $crawler = $this->client->get($series->getUri().'/komunita');
        $page = new CommunityPage($crawler, $this->client);

        $followers = $page->getUsers();
        $series->setFollowers($followers);

        return $followers;
    }

    /*public function getEvents(Series $series)
    {
        $crawler = $this->client->get($series->getUri().'/terminy');
        $page = new SeriesPage($crawler, $this->client);

        return $page->getEvents($series);
    }*/
}
