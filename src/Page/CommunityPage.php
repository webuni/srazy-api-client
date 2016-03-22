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
use Webuni\Srazy\Model\User;

class CommunityPage extends AbstractPage
{
    public function getUsers()
    {
        $users = $this->crawler->filter('.user-list a')->each(function (Crawler $node) {
            $uri = $node->link()->getUri();

            /* @var $user User */
            $user = $this->client->model(User::class, $uri);
            $user->setUri($uri);
            $user->setName($node->attr('title'));
            $user->setAvatar($node->filter('img')->image()->getUri());

            return $user;
        });

        return new ArrayCollection($users);
    }
}
