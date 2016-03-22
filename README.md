Srazy.info API Client
=====================

[![Latest Stable Version](https://poser.pugx.org/webuni/srazy-api-client/version)](https://packagist.org/packages/webuni/srazy-api-client)
[![Build Status](https://travis-ci.org/webuni/srazy-api-client.svg?branch=master)](https://travis-ci.org/webuni/srazy-api-client)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webuni/srazy-api-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/webuni/srazy-api-client/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/196f4e99-47c7-4801-ab67-707d2a852257/mini.png)](https://insight.sensiolabs.com/projects/196f4e99-47c7-4801-ab67-707d2a852257)

Instalace
---------

Knihovnu naintsalujem přes Composer:

```
composer require webuni/srazy-api-client
```

Použití
-------

Vytvoříme klienta
```php
use Webuni\Srazy\Client;

$client = new Client();
```

Klient umí pracovat s uživateli, srazy a jednotlivými událostmi 
```php
$userApi = $client->user();
$seriesApi = $client->series();
$eventApi = $client->event();
```

Srazy vyhledáme pomocí
```php
$series = $seriesApi->find('symfony')->first();
```

K jednotlivým vlastnostem srazu přistupujeme pomocí metod
```php
$series->getName();
$series->getDescription();
$series->getFollowers();
$series->getEvents();
```

U každé události můžeme přistupovat
```php
foreach ($series->getEvents() as $event) {
    $event->getName();
    $event->getDescription();
    $event->getStart();
    $event->getEnd();
    $event->gteLocation();
    $event->getSessions();
    $event->getComments();
}
```

Plán vývoje
-----------

* 1.0 - (duben 2016) kompletní API pro čtení veřejných informací
* 1.1 - podpora pro přihlášené uživatele a čtení informací viditelných pro přihlášené uživatele
* 2.0 - API pro úpravy
 
