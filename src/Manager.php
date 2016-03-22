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

use ProxyManager\Factory\LazyLoadingGhostFactory;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;

class Manager
{
    private $factory;
    private $identityMap = [];

    public function __construct(LazyLoadingValueHolderFactory $factory = null)
    {
        $this->factory = $factory ?: new LazyLoadingGhostFactory();
    }

    public function get($class, $uri, $initializer)
    {
        if (!isset($this->identityMap[$class][$uri])) {
            $this->identityMap[$class][$uri] = $this->createProxy($class, $initializer);
        }

        return $this->identityMap[$class][$uri];
    }

    private function createProxy($type, $initializer)
    {
        return $this->factory->createProxy($type, $initializer);
    }
}
