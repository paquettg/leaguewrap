LeagueWrap
==========

Version 0.6.0

[![Build Status](https://travis-ci.org/paquettg/leaguewrap.png?branch=master)](https://travis-ci.org/paquettg/leaguewrap)

LeagueWrap is a League of Legends API wrapper. The goal is to assist in the development of apps which depend on the Legue of Legends API in a quick and easy way. This project will help maintain a query limit for the API and a caching system, both which are still in progress. The mantra of this wrapper is to be lazy. We will only load the information you need when you need it and will do everything we can to reduce the amount of requests to the API. You'll notice, further into this README, choices that where made because of this mantra.

Install
-------

This package can be found on [packagist](https://packagist.org/packages/paquettg/leaguewrap) and is best loaded using [composer](http://getcomposer.org/). We support php 5.4, 5.5, 5.6 and hhvm.

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

It is also important to note that some regions, such as kr, require a certain url to be used and do not work on `prod.api.pvp.net`. This is taken care of automaticly and as long as you have the most recent version of the wrapper you do not need to worry about this.

Cache
-----

Caching is very important, we all know that and given the query limit impossed on every application this part of the package is very important to every developer. Given this, by default, the cache requires `memcached` to be installed and operating on default port and localhost. This can easily be changed by implementing your own version of the `LeagueWrap\CacheInterface`. Lets start with an example of how to use the cache.

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

Now we will only remember the response for the info() method is cached for 1 hour (3600 seconds). All other api objects, such as League, does not get effected by this cache time and, by default, does not cache the response. If you want to be able to only get a response if the request got a cache hit you can turn on the `cacheOnly` flag.

```php
use LeagueWrap\Api;

$api = new Api($myKey); // Load up the API
$api->remember()        // Enable cache with the default values.
    ->setCacheOnly()    // Only check the cache, don't do any http requests.
```

If the request was not found in cache it will throw a `LeagueWrap\Exception\CacheNotFoundException` exception. Simillarly to the `remember()` method this can also be called on the api endpoint object to only effect a certain request or endpoint while leaving the other ones untouched.

Now, lets say you don't want to use memcached or you wish to use the caching service provided by your framework? I completly understand and that is why you can implement the `LeagueWrap\CacheInterface` to implement your own cache. This Dependency Injection (DI) is also used by the Api client as shown in the Quick Reference section. To use your own cache implementation you can just do the following.

```php
use LeagueWrap\Api;

$api = new Api($myKey);       // Load up the API
$api->remember(60, $myCache); // Set the cache to use your own cache implementation
// or
$api->remember(null, $myCache); // Set the cache implementation but keep the default cache times
```

It's even easyer to do using StaticProxys, which you will see after the Rate Limiting section.

Rate Limiting
-------------

Even with caching you must also take into consideration the rate limits impossed on your api key. With this in mind we added support, similar to the support for caching, for limiting your request rate to the API. The rate limiting method requires `memcached` to be installed and operating on default port and localhost. As with the cache implementation you can always use your own version of the `LeagueWrap\LimitInterface`. Lets start with a basic example.

```php
use LeagueWrap\Api;

$api = new Api($myKey); // Load up the API
$api->limit(10, 10);    // Set a limit of 10 requests per 10 seconds
$api->limit(500, 600);  // Set a limit of 500 requests per 600 (10 minutes) seconds
```

The above will set the 2 limits that you will use for the average developer key at the time of writting. You can add as many limits to the collection as you wish and each one will be tracked in the memcached memory. If you go over the limit the application will throw a `LeagueWrap\Limit\LimitReachedException` exception. As with the Cache, it's just as easy to implement this using the DI of a proper `LeagueWrap\LimitInterface`, you may even use multiple Limit interfaces... not that I see a point to it.

```php
use LeagueWrap\Api;

$api = new Api($myKey);             // Load up the API
$api->limit(10, 10, $myLimiter);    // Set a limit using your own limit implementation
$api->limit(500, 600, $myLimiter); 
```

Also note that the limit functionality fully supports the Static API described further down.

Attach Static Data
------------------

Some requests come with static IDs referencing data in the static api. To do this you need to get the original data, extract the ID and follow up with a call to the static API. We make this entire process much simpler and optimize the amount of api requests that we do for all the data to reduce bandwidth and request. The extra static requests do not count towards your request limit so, in that regard, this does not effect the amount of requests you can do in a certain amount of time, it just takes time.

```php
use LeagueWrap\Api;

$api = new Api($myKey);                          // Load up the Api
$api->attachStaticData();                        // Tell the api to attach all static data
$champion = $api->champion()->championById(10);  // Get the champion by id 10
echo $champion->championStaticData->name;        // Outputs "Kayle"
```

It will also optimize the static call so that the following example only attempt 3 static api calls even if it requires over 2 dozen different static id for multiple DTOs.

```php
use LeagueWrap\Api;

$api = new Api($myKey);                          // Load up the Api
$api->attachStaticData();                        // Tell the api to attach all static data
$match = $api->match()->match(1399898747);
echo $match->team(0)->ban(0)->championStaticData->name; // outputs LeBlanc
```

StaticProxy
-----------

You can use LeagueWrap through a static client to make it even easier to send API requests.

```php
LeagueWrap\StaticApi::mount(); // Mount all the static static proxys

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

All normal API methods and API requests can be done using the static proxys and you no longer need to have an instance of `LeagueWrap\Api`. You must always set the key at least once before you can call any API requests but after it is set it will be used everywhere. The same can be applied to the cache reminder.

```php
LeagueWrap\StaticApi::mount(); // Mount all the static static proxys

Api::setKey('my-key');                // set the key for the API
Api::remember(60);                    // cache all request for 60 seconds
$bakasan = Summoner::info('bakasan'); // cached for 60 seconds
// or
Api::remember(60, $myCache);          // cache all request using my own 
$bakasan = Summoner::info('bakasan'); // cached for 60 seconds using $myCache
```

And with limits.

```php
LeagueWrap\StaticApi::mount(); // Mount all the static static proxys

Api::setKey('my-key');                // set the key for the API
Api::remember();                      // cache all request for the default number of seconds
Api::limit(10, 10);                   // Limit of 10 request per 10 seconds
Api::limit(500, 600);                 // Limit of 500 request per 10 minutes
$bakasan = Summoner::info('bakasan'); // cached for 60 seconds
```

Quick Reference
===============

LeagueWrap implements a very strict interface for the API where everything is within your control and easy to test. Here's a sampling of the possible startup methods.

Creates a new Api instance with the key. The key is mandatory and will throw a `LeagueWrap\NoKeyException` if not given. This instance will be used to orginize future calls to the API with out having to re-enter the key. 

```php
$api = new \LeagueWrap\Api($myKey);
```

Using the DI principle we allow you to inject your own client object that implements `LeagueWrap\ClientInterface`. This allows you to use your own REST client if you wish to instead of Guzzle (which is what comes with the package).

```php
$api = new \LeagueWrap\Api($myKey, $myClient);
```

Array Access
------------

A good number of the DTO response will extend `LeagueWrap\Dto\AbstractListDto` instead of `LeagueWrap\Dto\AbstractDto`. The DTO that extends the abstract list gain the ability to be used as an array for access, traversing (using `foreach()`), and counting (using `count()`).

```php
$game       = $api->game();
$games      = $game->recent(74602);
$mostRecent = $games->game(0);
// instead to access
$mostRecent = $games[0]; 

// traversing
foreach ($games as $game)
{
	// do some stuff to each recent game
}

// counting
$recentGameCount = count($games);
```

Setting Timeout
---------------

It is worth noting that the `LeagueWrap\ClientInterface` interface has a method called `setTimeout($seconds)`. You can invoke this feature by calling this method on the request object.

```php
$game = $api->game()
            ->setTimeout(3.14); // wait a maximum of 3.14 seconds for a response.
```

Or, you can call it directly on the API object which will then apply to any future request objects created.

```php
$api->setTimeout(3.14);
$game       = $api->game();
$mostRecent = $game->recent(74602); // this reques will wait a maximum of 3.14 seconds for a response.
```

Summoner
--------

To get an instance of the `LeagueWrap\Api\Summoner` object which is used to request information of the summoner API. This is the primary way you should be getting this object.

```php
$summoner = $api->summoner();
```

Selecting a valid version to be used by the summoner API. These version can be found in the object class file and we have a goal of only support at most 2 minor version of any major versions. Therefore you should not expect to be able to use v1.1 if v1.2 has been released for over a month.

```php
$summoner->selectVersion('v1.2')
```

Doing a summoner info request by the summoner name 'bakasan' will return a `LeagueWrap\Dto\Summoner` DTO that contains the information for this summoner.

```php
$bakasan = $summoner->info('bakasan');
```

You may also do an info request by the summoner id 76204. It works in the same way as the above method.

```php
$info = $summoner->info(76204);
```

To do a single request and get the information for multiple summoner ids you can pass in an array. It will then return an array of all the information about said summoners. You really should use this to get information from multiple summoners as it only costs you 1 request.

```php
$summoners = $summoner->info([
	76204,
	1234,
	111111,
	1337,
]);
```

You can also mix up ids and names and it will return an array. This will take 2 requests though, so be careful with it. Another limitation is a limit of 40 ids and 40 names per request, this is impossed by the API so we throw a `LeagueWrap\Api\ListMaxException` if you attempt this.

```php
$summoners = $summoner->info([
	76204,
	'C9 Hai',
	'riot',
	1234,
]);
```

If you wish to know how many requests you have done so far with a single API object you can always request the request count. It will simply return the number of requests to the API it has performed so far.

```php
$summoner->getRequestCount()
```

To get the only the name of a summoner but no other information (saves on data transfer and speed) you can us the name() method in the summoner object.

```php
$names = $summoner->name(76204);
```

It also accepts an array of ids instead of a single id and will return an associate array where `id => summonername`.

```php
$names = $summoner->name([
	76204,
	1234,
	1337,
	123456789
]);
```

To get the runePage of a summoner you have multiple options. First using the summoner request object and the summoner id. This will return an array of `LeagueWrap\Dto\RunePage` objects. The runePages() method also accepts an array of ids instead of a single id.

```php
$runePages = $summoner->runePages(76204);
```

And, lastly, you can use a summoner dto object that you received from info() or an array of such objects.

```php
$summoner->runePages($bakasan);
```

To get the first rune page of a summoner when you use the above method, passing in a summoner dto object, you can call the `runePage()` method of the object. The index of the runepage is what is expected as the first argument of the method call.

```php
$runePage = $bakasan->runePage(0);
```

The same applies to the mastery pages but using the `masteryPages()` method instead of the `runePages()` method on the summoner request object. We also have a short cut method `allInfo` which will get all the information for each summoner passed in. It works in the same way as `info` but does an extra 2 request for the rune pages and mastery pages information

```php
$bakasan = $summoner->allInfo(76204); // 3 requests
// or
$summoners = $summoner->allInfo([
	76204,
	'C9 Hai',
	'riot',
	1234,
]); // this will take 4 requests
```

Champion
--------

The champion api is very bare as most of the information in this api is static information so you are best to get that information from the static api. To get the champion request object you can call the `champion()` method on the api instance.

```php
$champion = $api->champion();
```

To get all champion information in a single request you only have to call the `all()` method. It will return a `LeagueWrap\Dto\ChampionList` object.

```php
$champions = $champion->all();
$kayle     = $champions->getChampion(10);
// or
$kayle     = $champions->champions[10];
```

You can also get the information about a single champion by id.

```php
$aatrox = $champion->championById(266);
```

Lastly, you can get a list of all free champions for the given region. This will return a `LeagueWrap\Dto\ChampionList` object, containing each free champion for the given region and week.

```php
$freeChampions = $champion->free();
```

Game
----

The game api is very simple but returns a lot of information about the given summoner. To get this request object you only need to call `game()` on the api object.

```php
$game = $api->game();
```

We have 2 ways of getting the information about a summoners recent games. You can either pass in the summoner id or the summoner object `LeagueWrap\Dto\Summoner` which has been loaded by a previous call to info. 

```php
$games = $game->recent(74602);
$game  = $games->recentGame(0);
// or
$game  = $games->games[0];
// or
$game->recent($bakasan);
$game = $bakasan->recentGame(0);
```

Match
----

The Match api can be used to get a more detailed match history then the game api provides. This does only include ranked games though. You can either pass in the summoner id or a summoner object `LeagueWrap\Dto\Summoner`.

```php
$matchHistory = $api->matchHistory();
$matches = $matchHistory->history(74602);

$match = $matches[0];
```

For even more details on a specific match, the match api can be used to get detailed statistics for every summoner as well as an optional timeline of events. As argument, you need to pass a match id that you can get from `LeagueWrap\Dto\Match->matchId` or `LeagueWrap\Dto\Game->gameId`.

```php
$matchapi = $api->match();
$match = $matchapi->match(1399898747);
```

To include the timeline:

```php
$matchapi = $api->match();
$match = $matchapi->match(1399898747, true);

$timeline = $match->timeline
```

League
------

The documentation for the League Api is not complete but it is fully functional.

```php
$league = $api->league();
```

Stat
----

The documentation for the Stat Api is not complete but it is fully functional.

```php
$stat = $api->stat();
```

Team
----

The documentation for the Team Api is not complete but it is fully functional.

```php
$team = $api->team();
```

Static Data
-----------

The documentation for the Static Data Api is not complete but it is fully functional.

```php
$staticData = $api->staticData();
```

Disclaimer
----------

It is the responsibility of the User to evaluate the content and I will not be liable for any damage or loss caused by the use of this open source software. We do not provide any guarantee that the software will do as expeccted and it is the responsiblity of the User to ensure that the interaction with the software is correct.

This product is not endorsed, certified or otherwise approved in any way by Riot Games, Inc. or any of its affiliates.
