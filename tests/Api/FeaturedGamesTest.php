<?php

use LeagueWrap\Api;
use Mockery as m;

class FeaturedGamesTest extends PHPUnit_Framework_TestCase 
{
	
	protected $client;

	public function setUp()
	{
		$client       = m::mock('LeagueWrap\Client');
		$this->client = $client;
	}

	public function tearDown()
	{
		m::close();
	}

	public function testFeaturedGames()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once()
		             ->with('https://na.api.pvp.net/observer-mode/rest/');
		$this->client->shouldReceive('request')
		             ->with('featured', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/featuredgames.na.json'));

		$api = new Api('key', $this->client);
		$featuredGames = $api->featuredGames()->featuredGames();
		$this->assertEquals(1718765493, $featuredGames[0]->gameId);
	}
}
