LeagueWrap
==========

Version 0.1

LeagueWrap is a League of Legends API wrapper. The goal is to assist in the development of apps which depend on the Legue of Legends API in a quick and easy way. This project will help maintain a query limit for the API and a caching system, both which are still in progress. The mantra of this wrapper is to be lazy. We will only load the information you need when you need it and will do everything we can to reduce the amount of requests to the API. You'll notice, further into this README, choices that where made because of this mantra.

Install
-------

This package can be found on [packagist](https://packagist.org/packages/paquettg/leaguewrap) and is best loaded using [composer](http://getcomposer.org/).

Simple Example
--------------

You can find many examples of how to use the wrapper and any of its parts (which you will most likely never touch) in the tests directory. The tests are done using PHPUnit and are very small, a few lines each, and are a great place to start. Given that, I'll still be showing examples of how the package is intended to work. The following example is a very simplistic usage of the package, good place to start.

```php
use LeagueWrap\Api;

$api      = new Api($myKey);           // Load up the API
$summoner = $api->summoner();          // Load up the summoner request object.
$bakasan  = $summoner->info('bakasan') // Get the information about this user.

$bakasan = $summoner->info(74602)      // same thing as above, just to show that an id will work

echo $bakasan->summonerLevel;          // 30
echo $bakasan->id;                     // 74602
echo $bakasan->name;                   // "bakasan"
echo $bakasan->profileIconId;          // 24
echo $bakasan->revisionDate;           // 1387391523000
echo $bakasan->revisionDateStr;        // "12/18/2013 06:32 PM UTC"
```

The above gets the basic information about the user 'bakasan'. The above example illustrates the general idea of how things work. You load up the API with your given key, this API object can be used as many times as possible and is encouraged to only have one instance of it. From the API you can select which API to query (in this case the summoner API). Finally, you use a method, dependant of the API you query, to perform a request on that API.

Regions
-------

You can set the region that you wish to query. By default it is 'na' but it can be changed to any string.

```php
use LeagueWrap\Api

$api = new Api($myKey);  // Load up the API
$api->setRegion('euw');  // Set the region to 'euw'
```

The above is straight forward and applies to all API request objects that this API will generate. There is also built in support for API calls that restrict regional access. Continuing from the above code snippet.

```php
$api->setRegion('br');                 // Set the region to 'br'
$champions = $api->champion()->free(); // will throw a LeagueWrap\Api\RegionException
```

The `LeagueWrap\Api\RegionException` in the above example will contain the string `'The region "br" is not permited to query this API.'`.

Facade
------

You can use LeagueWrap through a static client to make it even easier to send API requests.

```php
LeagueWrap\StaticApi::mount(); // Mount all the static facades

Api::setKey('my-key'); // set the key for the API

$summoner = Api::summoner(); // get a LeagueWrap\Api\Summoner instance
$summoner->info('bakasan');  // get info about summoner
echo $summoner->bakasan->id; // 74602
// or
Summoner::info('bakasan');        // get info about the summoner 'bakasan'
echo Summoner::get('bakasan')->id // 74602

Game::recent(Summoner::get('bakasan'));          // get the recent games for bakasan
$game = Summoner::get('bakasan')->recentGame(0); // get the most recent game
```

All normal API methods and API requests can be done using the facades and you no longer need to have an instance of `LeagueWrap\Api`. You must always set the key at least once before you can call any API requests but after it is set it will be used everywhere. 

Quick Reference
---------------

LeagueWrap implements a very strict interface for the API where everything is within your control and easy to test. Here's a sampling of the possible startup methods.

```php
$api = new \LeagueWrap\Api($myKey);
```

Creates a new Api instance with the key. The key is mandatory and will throw an exception if not given. This instance will be used to orginize future calls to the API with out having to re-enter the key. 

```php
$api = new \LeagueWrap\Api($myKey, $myClient);
```

Using the Dependency Injection (DI) principle we allow you to inject your own client object that implements `LeagueWrap\ClientInterface`. This allows you to use your own REST client if you wish to instead of Guzzle (which is what comes with the package).

```php
$summoner = $api->summoner();
```

This gets you an instance of the `LeagueWrap\Api\Summoner` object which is used to request information of the summoner API. This is the primary way you should be getting this object.

```php
$summoner = new \LeagueWrap\Api\Summoner($myClient);
$summoner->setKey($myKey);
$summoner->setRegion('na');
```

This is an alternative method of loading a summoner object with out having to use the Api instance. This is not recommended but it is possible if you find yourself in a situation where you can't live with out it.

```php
$summoner->selectVersion('v1.2')
```

Selecting a valid version to be used by the summoner API. These version can be found in the object class file and we have a goal of only support at most 2 minor version of any major versions. Therefore you should not expect to be able to use v1.1 if v1.2 has been released for over a month.

```php
$bakasan = $summoner->info('bakasan');
```

Doing a summoner info request by the summoner name 'bakasan' will return a `LeagueWrap\Response\Summoner` DTO that contains the information for this summoner.

```php
$info = $summoner->info(76204);
```

The above will do an info request by the summoner id 76204 and works the same as the above method.

```php
$summoner->getRequestCount()
```

If you wish to know how many requests you have done so far with a single API object you can always request the request count. It will simply return the number of requests to the API it has performed so far.
