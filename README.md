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
use LeagueWrap\Api;

$api = new Api($myKey);  // Load up the API
$api->setRegion('euw');  // Set the region to 'euw'
```

The above is straight forward and applies to all API request objects that this API will generate. There is also built in support for API calls that restrict regional access. Continuing from the above code snippet.

```php
$api->setRegion('br');                 // Set the region to 'br'
$champions = $api->champion()->free(); // will throw a LeagueWrap\Api\RegionException
```

The `LeagueWrap\Api\RegionException` in the above example will contain the string `'The region "br" is not permited to query this API.'`.

Cache
-----

Caching is very important, we all know that and given the query limit impossed on every application this part of the package is very important to every developer. Given this, by default, the cache requiers `memcached` to be installed and operation on default port and localhost. This can easily be changed by implementing your own version of the cacheInterface. Lets start with an example of how to use the cache.

```php
use LeagueWrap\Api;

$api = new Api($myKey); // Load up the API
$api->remember(60);     // Set the cache to remember every request for 60 seconds
// or
$api->remember();     // Enable cache with the default value for each api call.
$api->remember(null); // Same as above, null is the default value
```

The above applies to every future request done trough the `$api` methods. If you wish to set the cache time for any individual request, which is reasonable given that things change at a different pace.

```php
use LeagueWrap\Api;

$api      = new Api($myKey);           // Load up the API
$summoner = $api->summoner()           // Get the summoner api request object
                ->remember(3600);      // Remember all request done by this single request object
$bakasan = $summoner->info('bakasan'); // This request is cached for 1 hour (3600 seconds)
```

Now we will only remember the response for the info() method is cached for 1 hour (3600 seconds). All other api objects, such as League, does not get effected by this cache time and, by default, does not cache the response.

Now, lets say you don't want to use memcached or you wish to use the caching service provided by your framework? I completly understand and that is why you can implement the `LeagueWrap\CacheInterface` to implement your own cache. This Dependency Injection (DI) is also used by the Api client as shown in the Quick Reference section. To use your own cache implementation you can just do the following.

```php
use LeagueWrap\Api;

$api = new Api($myKey);       // Load up the API
$api->remember(60, $myCache); // Set the cache to use your own cache implementation
// or
$api->remember(null, $myCache); // Set the cache implementation but keep the default cache times
```

It's even easyer to do using Facades, which you will see in the next second.

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

All normal API methods and API requests can be done using the facades and you no longer need to have an instance of `LeagueWrap\Api`. You must always set the key at least once before you can call any API requests but after it is set it will be used everywhere. The same can be applied to the cache reminder.

```
LeagueWrap\StaticApi::mount(); // Mount all the static facades

Api::setKey('my-key');                // set the key for the API
Api::remember(60);                    // cache all request for 60 seconds
$bakasan = Summoner::info('bakasan'); // cached for 60 seconds
// or
Api::remember(60, $myCache);          // cache all request using my own 
$bakasan = Summoner::info('bakasan'); // cached for 60 seconds using $myCache
```

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

Using the DI principle we allow you to inject your own client object that implements `LeagueWrap\ClientInterface`. This allows you to use your own REST client if you wish to instead of Guzzle (which is what comes with the package).

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
$summoners = $summoner->info([
	76204,
	1234,
	111111,
	1337,
]);
```

The above will do a simgle request and get the information for the summoner of all the ids given. It will then return an array of all the information about said summoners. You really should use this to get information from multiple summoners as it only costs you 1 request.

```php
$summoners = $summoner->info([
	76204,
	'C9 Hai',
	'riot',
	1234,
]);
```

You can also mix up ids and names and it will return an array. This will take 2 requests though, so be careful with it. Another limitation is a limit of 40 ids and 40 names per request, this is impossed by the API so we throw a `LeagueWrap\Api\ListMaxException` if you attempt this.

```php
$summoner->getRequestCount()
```

If you wish to know how many requests you have done so far with a single API object you can always request the request count. It will simply return the number of requests to the API it has performed so far.

```php
$names = $summoner->name(76204);
```

It also accepts an array of ids instead of a single id and will return an associate array where `id => summonername`.

The remaining methods list is not complete and will be documented soon enough. Sorry about the delay.

```php
$runePages = $summoner->runePage($bakasan);
```

```php
$runePage = $bakasan->runePage(0);
```

```php
$masteryPages = $summoner->masteryPages($bakasan);
```

```php
$masteryPage = $bakasan->masteryPage(0);
```

```php
$bakasan = $summoner->allInfo(76204);
```

```php
$champion = $api->champion();
```

```php
$champions = $champion->all();
```

```php
$freeChampions = $champion->free();
```

```php
$game = $api->game();
```

```php
$games = $game->recent(74602);
```

```php
$games = $game->recent($bakasan);
```

```php
$game = $bakasan->recentGame(0);
```

```php
$league = $api->league();
```

