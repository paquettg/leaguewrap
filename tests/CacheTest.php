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
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with('{"champions":[{"id":103,"name":"Ahri","active":true,"attackRank":3,"defenseRank":4,"magicRank":8,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":51,"name":"Caitlyn","active":true,"attackRank":8,"defenseRank":2,"magicRank":2,"difficultyRank":4,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":42,"name":"Corki","active":true,"attackRank":8,"defenseRank":3,"magicRank":6,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":105,"name":"Fizz","active":true,"attackRank":6,"defenseRank":4,"magicRank":7,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":121,"name":"Khazix","active":true,"attackRank":9,"defenseRank":4,"magicRank":3,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":99,"name":"Lux","active":true,"attackRank":2,"defenseRank":4,"magicRank":9,"difficultyRank":6,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":33,"name":"Rammus","active":true,"attackRank":4,"defenseRank":10,"magicRank":5,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":107,"name":"Rengar","active":true,"attackRank":7,"defenseRank":4,"magicRank":2,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":44,"name":"Taric","active":true,"attackRank":4,"defenseRank":8,"magicRank":5,"difficultyRank":3,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":77,"name":"Udyr","active":true,"attackRank":8,"defenseRank":7,"magicRank":4,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true}]}', '56e2f3462cbfb9c90eb2450e746da71d', 60)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('56e2f3462cbfb9c90eb2450e746da71d')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('56e2f3462cbfb9c90eb2450e746da71d')
		            ->andReturn('{"champions":[{"id":103,"name":"Ahri","active":true,"attackRank":3,"defenseRank":4,"magicRank":8,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":51,"name":"Caitlyn","active":true,"attackRank":8,"defenseRank":2,"magicRank":2,"difficultyRank":4,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":42,"name":"Corki","active":true,"attackRank":8,"defenseRank":3,"magicRank":6,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":105,"name":"Fizz","active":true,"attackRank":6,"defenseRank":4,"magicRank":7,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":121,"name":"Khazix","active":true,"attackRank":9,"defenseRank":4,"magicRank":3,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":99,"name":"Lux","active":true,"attackRank":2,"defenseRank":4,"magicRank":9,"difficultyRank":6,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":33,"name":"Rammus","active":true,"attackRank":4,"defenseRank":10,"magicRank":5,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":107,"name":"Rengar","active":true,"attackRank":7,"defenseRank":4,"magicRank":2,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":44,"name":"Taric","active":true,"attackRank":4,"defenseRank":8,"magicRank":5,"difficultyRank":3,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":77,"name":"Udyr","active":true,"attackRank":8,"defenseRank":7,"magicRank":4,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true}]}');

		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.1/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		            ->andReturn('{"champions":[{"id":103,"name":"Ahri","active":true,"attackRank":3,"defenseRank":4,"magicRank":8,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":51,"name":"Caitlyn","active":true,"attackRank":8,"defenseRank":2,"magicRank":2,"difficultyRank":4,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":42,"name":"Corki","active":true,"attackRank":8,"defenseRank":3,"magicRank":6,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":105,"name":"Fizz","active":true,"attackRank":6,"defenseRank":4,"magicRank":7,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":121,"name":"Khazix","active":true,"attackRank":9,"defenseRank":4,"magicRank":3,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":99,"name":"Lux","active":true,"attackRank":2,"defenseRank":4,"magicRank":9,"difficultyRank":6,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":33,"name":"Rammus","active":true,"attackRank":4,"defenseRank":10,"magicRank":5,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":107,"name":"Rengar","active":true,"attackRank":7,"defenseRank":4,"magicRank":2,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":44,"name":"Taric","active":true,"attackRank":4,"defenseRank":8,"magicRank":5,"difficultyRank":3,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":77,"name":"Udyr","active":true,"attackRank":8,"defenseRank":7,"magicRank":4,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true}]}');

		$api = new LeagueWrap\Api('key', $this->client);
		$champion = $api->champion()
		                ->remember(60, $this->cache);
		$champion->free();
		$champion->free();
		$this->assertEquals(1, $champion->getRequestCount());
	}

	public function testRememberSummonerFacade()
	{
		$this->cache->shouldReceive('set')
		            ->once()
		            ->with('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}', 'bbc4b6dc46d287ee7ca219dc988bca71', 10)
		            ->andReturn(true);
		$this->cache->shouldReceive('has')
		            ->twice()
		            ->with('bbc4b6dc46d287ee7ca219dc988bca71')
		            ->andReturn(false, true);
		$this->cache->shouldReceive('get')
		            ->once()
		            ->with('bbc4b6dc46d287ee7ca219dc988bca71')
		            ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');

		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::remember(10, $this->cache);
		Summoner::info('bakasan');
		Summoner::info('bakasan');
		$this->assertEquals(1, Summoner::getRequestCount());
	}
}
