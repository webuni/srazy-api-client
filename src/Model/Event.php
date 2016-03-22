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

class Event
{
    private $uri;

    private $name;

    private $description;

    private $series;

    private $sessions;

    private $start;

    private $end;

    private $address;

    private $mapUrl;

    private $confirmedAttendees;

    private $unconfirmedAttendees;

    private $comments;

    private $location;

    public function __construct($name = null, $uri = null, \DateTime $date = null)
    {
        $this->name = $name;
        $this->uri = $uri;
        $this->start = $date;
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

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getMapUrl()
    {
        return $this->mapUrl;
    }

    public function setMapUrl($mapUrl)
    {
        $this->mapUrl = $mapUrl;
    }

    public function getSeries()
    {
        return $this->series;
    }

    public function setSeries(Series $series = null)
    {
        $this->series = $series;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart(\DateTime $start = null)
    {
        $this->start = $start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd(\DateTime $end = null)
    {
        $this->end = $end;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * @param Session[]|ArrayCollection $sessions
     */
    public function setSessions(ArrayCollection $sessions)
    {
        $this->sessions = $sessions;

        if (null !== $this->end) {
            return;
        }

        foreach ($sessions as $session) {
            if ($session->isType(Session::TYPE_END)) {
                $this->setEnd($session->getStart());
                break;
            }
        }
    }

    public function getConfirmedAttendees()
    {
        return $this->confirmedAttendees;
    }

    public function setConfirmedAttendees(ArrayCollection $confirmedAttendees)
    {
        $this->confirmedAttendees = $confirmedAttendees;
    }

    public function getUnconfirmedAttendees()
    {
        return $this->unconfirmedAttendees;
    }

    public function setUnconfirmedAttendees(ArrayCollection $unconfirmedAttendees)
    {
        $this->unconfirmedAttendees = $unconfirmedAttendees;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments(ArrayCollection $comments)
    {
        $this->comments = $comments;
    }
}
