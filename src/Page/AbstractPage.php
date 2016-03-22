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

use Webuni\Srazy\Client;
use Webuni\Srazy\Crawler;

class AbstractPage
{
    protected $crawler;
    protected $client;

    public function __construct(Crawler $crawler, Client $client)
    {
        $this->crawler = $crawler;
        $this->client = $client;
    }
}
