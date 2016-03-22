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
use Webuni\Srazy\Model\Series;
use Webuni\Srazy\Model\User;

class SearchPage extends AbstractPage
{
    public function getSeries()
    {
        $series = $this->crawler->filter('.body-default .span6:first-child h3 a')->each(function (Crawler $link) {
            $uri = $link->link()->getUri();
            $series = $this->client->model(Series::class, $uri);
            $series->setName($link->text());
            $series->setUri($uri);

            return $series;
        });

        return new ArrayCollection($series);
    }

    public function getUsers()
    {
        $users = $this->crawler->filter('.body-default .span6 + .span6 h3 a')->each(function (Crawler $link) {
            $uri = $link->link()->getUri();
            $user = $this->client->model(User::class, $uri);
            $user->setName($link->text());
            $user->setUri($link->link()->getUri());

            return $user;
        });

        return new ArrayCollection($users);
    }
}
