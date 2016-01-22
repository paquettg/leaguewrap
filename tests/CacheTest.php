<?php

use Mockery as m;

class CacheTest extends PHPUnit_Framework_TestCase {

	protected $cache;
	protected $client;

	public function setUp()
	{
		$this->cache  = m::mock('LeagueWrap\CacheInterface');
		$this->client = m::mock('LeagueWrap\Client');
	}

	public function tearDown()
	{
		m::close();
	}

	public function testRememberChampion()
	{
		$champions = file_get_contents('tests/Json/champion.free.json');
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with('39a7ac3476de98ba9d05b2d6824c5d03', $champions, 60)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('39a7ac3476de98ba9d05b2d6824c5d03')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('39a7ac3476de98ba9d05b2d6824c5d03')
		            ->andReturn($champions);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn($champions);

		$api      = new LeagueWrap\Api('key', $this->client);
		$champion = $api->champion()
		                ->remember(60, $this->cache);
		$champion->free();
		$champion->free();
		$this->assertEquals(1, $champion->getRequestCount());
	}

	/**
	 * @expectedException LeagueWrap\Response\HttpClientError
	 * @expectedExceptionMessage Resource not found.
	 */
	public function testRememberChampionClientError()
	{
		$this->cache->shouldReceive('set')
		            ->once()
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('ce0ca052a398f2b25f35da9596372146')
		            ->andReturn(false, true);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('v1.2/champion/10101', [
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(new LeagueWrap\Response(file_get_contents('tests/Json/champion.json'), 404));

		$api      = new LeagueWrap\Api('key', $this->client);
		$champion = $api->champion()
		                ->remember(60, $this->cache);
		try
		{
			$champion->championById(10101);
		}
		catch (LeagueWrap\Response\HttpClientError $exception)
		{
			$this->cache->shouldReceive('get')
		            	->once()
		            	->with('ce0ca052a398f2b25f35da9596372146')
		            	->andReturn($exception);
			$champion->championById(10101);
		}
	}

	public function testRememberChampionCacheOnly()
	{
		$champions = file_get_contents('tests/Json/champion.free.json');
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('39a7ac3476de98ba9d05b2d6824c5d03')
		            ->andReturn(true);
		$this->cache->shouldReceive('get')
		            ->twice()
		            ->with('39a7ac3476de98ba9d05b2d6824c5d03')
		            ->andReturn($champions);

		$this->client->shouldReceive('baseUrl')
		             ->twice();

		$api = new LeagueWrap\Api('key', $this->client);
		$api->setCacheOnly()
		    ->remember(60, $this->cache);
		$champion = $api->champion();
		$champion->free();
		$champion->free();
		$this->assertEquals(0, $champion->getRequestCount());
	}

	/**
	 * @expectedException LeagueWrap\Exception\CacheNotFoundException
	 */
	public function testRememberSummonerCacheOnlyNoHit()
	{
		$bakasan = file_get_contents('tests/Json/summoner.bakasan.json');
		$this->cache->shouldReceive('has')
		            ->once()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn(false);
		$this->client->shouldReceive('baseUrl')
		             ->once();

		$api = new LeagueWrap\Api('key', $this->client);
		$api->remember(null, $this->cache)
		    ->setCacheOnly();
		$summoner = $api->summoner()->info('bakasan');
	}

	public function testRememberSummonerStaticProxy()
	{
		$bakasan = file_get_contents('tests/Json/summoner.bakasan.json');
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b', $bakasan, 10)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn($bakasan);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($bakasan);

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::remember(10, $this->cache);
		Summoner::info('bakasan');
		Summoner::info('bakasan');
		$this->assertEquals(1, Summoner::getRequestCount());
	}

	public function testCaching4xxError()
	{
		$response = new LeagueWrap\Response('', 404);
		$exception = new LeagueWrap\Response\Http404('', 404);
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b', m::any(), 10)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn($exception);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($response);

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::remember(10, $this->cache);
		try
		{
			Summoner::info('bakasan');
		}
		catch (LeagueWrap\Response\Http404 $e) {}
		try
		{
			Summoner::info('bakasan');
		}
		catch (LeagueWrap\Response\Http404 $e) {}

		$this->assertEquals(1, Summoner::getRequestCount());
	}

	public function testNoCaching4xxError()
	{
		$response = new LeagueWrap\Response('', 404);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn(false, false);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->twice()
		             ->andReturn($response);

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::remember(10, $this->cache);
		Api::setClientErrorCaching(false);
		try
		{
			Summoner::info('bakasan');
		}
		catch (LeagueWrap\Response\Http404 $e) {}
		try
		{
			Summoner::info('bakasan');
		}
		catch (LeagueWrap\Response\Http404 $e) {}

		$this->assertEquals(2, Summoner::getRequestCount());
	}

	public function testCaching5xxError()
	{
		$response = new LeagueWrap\Response('', 500);
		$exception = new LeagueWrap\Response\Http500('', 500);

		$this->cache->shouldReceive('set')
		            ->once()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b', m::any(), 10)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn($exception);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($response);

		LeagueWrap\StaticApi::mount();
		$api = new LeagueWrap\Api('key', $this->client);
		$api->remember(10, $this->cache);
		$api->setServerErrorCaching();
		$summoner = $api->summoner();
		try
		{
			$summoner->info('bakasan');
		}
		catch (LeagueWrap\Response\Http500 $e) {}
		try
		{
			$summoner->info('bakasan');
		}
		catch (LeagueWrap\Response\Http500 $e) {}

		$this->assertEquals(1, $summoner->getRequestCount());
	}

	public function testNoCaching5xxError()
	{
		$response = new LeagueWrap\Response('', 500);
		$exception = new LeagueWrap\Response\Http500('', 500);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('6afe3618f432d7b6a98336b85ae1e04b')
		            ->andReturn(false, false);

		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->twice()
		             ->andReturn($response);

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::remember(10, $this->cache);
		try
		{
			Summoner::info('bakasan');
		}
		catch (LeagueWrap\Response\Http500 $e) {}
		try
		{
			Summoner::info('bakasan');
		}
		catch (LeagueWrap\Response\Http500 $e) {}

		$this->assertEquals(2, Summoner::getRequestCount());
	}
}
