LeagueWrap
==========

Version 0.0

LeagueWrap is a League of Legends API wrapper. The goal is to assist in the development of apps which depend on the Legue of Legends API in a quick and easy way. This project will help maintain a query limit for the API and a caching system, both which are still in progress. The mantra of this wrapper is to be lazy. We will only load the information you need when you need it and will do everything we can to reduce the amount of requests to the API. You'll notice, further into this README, choices that where made because of this mantra.

Install
-------

This package can be found on [packagist](https://packagist.org/packages/paquettg/leaguewrap) and is best loaded using [composer](http://getcomposer.org/).

Usage
-----

You can find many examples of how to use the wrapper and any of its parts (which you will most likely never touch) in the tests directory. The tests are done using PHPUnit and are very small, a few lines each, and are a great place to start. Given that, I'll still be showing examples of how the package is intended to work. The following example is a very simplistic usage of the package, good place to start.

```php
use LeagueWrap\Api;

$api      = new Api($myKey);           // Load up the API
$summoner = $api->summoner()           // Load up the summoner request object.
$bakasan  = $summoner->info('bakasan') // Get the information about this user.

$bakasan = $summoner->info(74602)      // same thing as above, just to show that an id will work

echo $bakasan->summonerLevel;          // 30
echo $bakasan->id;                     // 74602
echo $bakasan->name;                   // "bakasan"
echo $bakasan->profileIconId;          // 24
echo $bakasan->revisionDate;           // 1387391523000
echo $bakasan->revisionDateStr;        // "12/18/2013 06:32 PM UTC"
```

The above gets the basic information about the user 'bakasan'. It is a very simple example but it gets the general idea of how things work. You load up the API with your given key, this API object can be used as many times as possible and is encouraged to only have one instance of it. From the API you can select which API to query (in this case the summoner api). Finally, you use a method, dependant of the PI you query, to performe a request on that API.

Setting the Region
------------------

You can set the region that you wish to query. By default it is 'na' but it can be changed to any string.

```php
use LeagueWrap\Api

$api = new Api($myKey);  // Load up the API
$api->setRegion('euw');  // Set the region to 'euw'
```

Really easy no?


