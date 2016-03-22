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

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7;
use ProxyManager\Proxy\GhostObjectInterface;

class Client
{
    private $httpClient;
    private $manager;
    private $baseUri;

    public function __construct(HttpClient $httpClient = null, Manager $manager = null)
    {
        $this->httpClient = $httpClient ?: new HttpClient();
        $this->manager = $manager ?: new Manager();
        $this->baseUri = Psr7\uri_for('http://srazy.info');
    }

    public function series()
    {
        return new Api\SeriesApi($this, $this->manager);
    }

    public function user()
    {
        return new Api\UserApi($this, $this->manager);
    }

    public function event()
    {
        return new Api\EventApi($this, $this->manager);
    }

    public function api($type)
    {
        if (class_exists($type)) {
            $type = (new \ReflectionClass($type))->getShortName();
        }

        return $this->{$type}();
    }

    public function ajax($url, array $options = [], \Closure $processor = null)
    {
        $options['headers'] = array_merge(isset($options['headers']) ? $options['headers'] : [], ['X-Requested-With' => 'XMLHttpRequest']);

        return $this->get($url, $options, $processor);
    }

    public function get($url, array $options = [], \Closure $processor = null)
    {
        $url = Psr7\Uri::resolve($this->baseUri, $url);
        $response = $this->httpClient->get($url, $options);

        if (null !== $processor) {
            $response = $processor($response);
        }

        $crawler = new Crawler(null, (string) $url, (string) $this->baseUri);
        $crawler->addContent($response->getBody());

        return $crawler;
    }

    public function model($class, $uri)
    {
        return $this->manager->get($class, $uri, $this->initializer($class, $uri));
    }

    private function initializer($class, $uri)
    {
        $initializer = function (GhostObjectInterface &$wrappedObject, $method, array $parameters) use ($class, $uri) {
            if (!method_exists($wrappedObject, $method)) {
                return;
            }

            if (0 === strpos($method, 'set')) {
                return;
            }

            if (null !== call_user_func([$wrappedObject, $method], $parameters)) {
                return;
            }

            $api = $this->api($class);
            if (method_exists($api, $method)) {
                $api->{$method}($wrappedObject);

                return;
            }

            $wrappedObject = $api->get($wrappedObject);
        };

        return $initializer;
    }
}
