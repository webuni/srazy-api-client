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

use Webuni\Srazy\Page\SearchPage;

class UserApi extends AbstractApi
{
    public function find($user)
    {
        $crawler = $this->client->get(sprintf('/hledat/?s=%s', urlencode($user)));
        $page = new SearchPage($crawler, $this->client);

        return $page->getUsers();
    }

    public function get($user)
    {
    }
}
