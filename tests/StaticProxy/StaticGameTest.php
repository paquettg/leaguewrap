<?php

use Mockery as m;

class StaticProxyStaticGameTest extends PHPUnit_Framework_TestCase {

	protected $client;

	public function setUp()
	{
		$this->client = m::mock('LeagueWrap\Client');
		LeagueWrap\StaticApi::mount();
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

		Api::setKey('key', $this->client);
		$games = Game::recent(74602);
		$this->assertTrue($games instanceof LeagueWrap\Dto\RecentGames);
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

		Api::setKey('key', $this->client);
		$bakasan = Summoner::info('bakasan');
		$games   = Game::recent($bakasan);
		$this->assertTrue($bakasan->recentGame(0) instanceof LeagueWrap\Dto\Game);
	}
}

