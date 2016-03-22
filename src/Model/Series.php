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

namespace Webuni\Srazy\Model;

use Doctrine\Common\Collections\ArrayCollection;

class Series
{
    private $uri;

    private $name;

    private $description;

    private $followers;

    private $events;

    public function __construct($name = null, $uri = null)
    {
        $this->name = $name;
        $this->uri = $uri;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Event[]|ArrayCollection
     */
    public function getEvents()
    {
        return $this->events;
    }

    public function setEvents(ArrayCollection $events)
    {
        $this->events = $events;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    public function setFollowers(ArrayCollection $followers)
    {
        $this->followers = $followers;
    }
}
