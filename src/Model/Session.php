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

class Session
{
    const TYPE_REGISTRATION = 'registration';
    const TYPE_START = 'start';
    const TYPE_TALK = 'talk';
    const TYPE_BREAK = 'break';
    const TYPE_LUNCH = 'lunch';
    const TYPE_COFFEE = 'caffee';
    const TYPE_BEAR = 'bear';
    const TYPE_NETWORKING = 'networking';
    const TYPE_END = 'end';
    const TYPE_OTHER = 'other';

    private $title;

    private $speaker;

    private $description;

    private $type;

    private $start;

    private $stop;

    private $event;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSpeaker()
    {
        return $this->speaker;
    }

    public function setSpeaker($speaker)
    {
        $this->speaker = $speaker;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart(\DateTime $start = null)
    {
        $this->start = $start;
    }

    public function getStop()
    {
        return $this->stop;
    }

    public function setStop(\DateTime $stop = null)
    {
        $this->stop = $stop;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function isType($type)
    {
        return $this->type === $type;
    }
}
