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

namespace Webuni\Srazy;

use Symfony\Component\DomCrawler\Crawler as BaseCrawler;

class Crawler extends BaseCrawler
{
    public function getUri()
    {
        return $this->uri;
    }

    public function isEmpty()
    {
        return 0 === $this->count();
    }

    public function croppedText()
    {
        return trim($this->text());
    }
}
