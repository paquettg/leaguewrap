<?php

use Mockery as m;

class CacheTest extends PHPUnit_Framework_TestCase {

	protected $cache;
	protected $client;

	public function setUp()
	{
		$this->cache  = m::mock('LeagueWrap\Cache');
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
		            ->with($champions, '56e2f3462cbfb9c90eb2450e746da71d', 60)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('56e2f3462cbfb9c90eb2450e746da71d')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('56e2f3462cbfb9c90eb2450e746da71d')
		            ->andReturn($champions);

		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.1/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn($champions);

		$api = new LeagueWrap\Api('key', $this->client);
		$champion = $api->champion()
		                ->remember(60, $this->cache);
		$champion->free();
		$champion->free();
		$this->assertEquals(1, $champion->getRequestCount());
	}

	public function testRememberSummonerFacade()
	{
		$bakasan = file_get_contents('tests/Json/summoner.bakasan.json');
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with($bakasan, '8eed0f537fda2bfef50daf6dd53389e0', 10)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('8eed0f537fda2bfef50daf6dd53389e0')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('8eed0f537fda2bfef50daf6dd53389e0')
		            ->andReturn($bakasan);

		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/by-name/bakasan', [
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
}
