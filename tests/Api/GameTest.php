<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiGameTest extends PHPUnit_Framework_TestCase {

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

	public function testRecent()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));

		$api   = new Api('key', $this->client);
		$games = $api->game()->recent(74602);
		$this->assertTrue($games instanceof LeagueWrap\Dto\RecentGames);
	}

	public function testRecentArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));

		$api   = new Api('key', $this->client);
		$games = $api->game()->recent(74602);
		$this->assertTrue($games[0] instanceof LeagueWrap\Dto\Game);
	}

	public function testRecentSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		$api     = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$games   = $api->game()->recent($bakasan);
		$this->assertTrue($bakasan->recentGame(0) instanceof LeagueWrap\Dto\Game);
	}

	public function testRecentStatsSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		$api     = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$games   = $api->game()->recent($bakasan);
		$game    = $bakasan->recentGame(0);
		$this->assertEquals(13, $game->stats->level);
	}

	public function testRecentStatsSummonerRaw()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		$api     = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$games   = $api->game()->recent($bakasan);
		$game    = $bakasan->recentGame(0)->raw();
		$this->assertEquals(13, $game['stats']['level']);
	}
}

