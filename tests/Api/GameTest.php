<?php

use LeagueWrap\Api;

class ApiGameTest extends PHPUnit_Framework_TestCase {

	protected $game;

	protected $summoner;

	public function setUp()
	{
		$key = trim(file_get_contents('tests/key.txt'));
		$api = new Api($key);
		$this->game = $api->game();
		$this->summoner = $api->summoner();
	}

	public function testRecent()
	{
		$games = $this->game->recent(74602);
		$game  = reset($games); // get first game
		$this->assertEquals(9, count($game->fellowPlayers));
	}

	public function testRecentSummoner()
	{
		$this->summoner->info('bakasan');
		$this->game->recent($this->summoner->bakasan);
		$this->assertTrue($this->summoner->bakasan->recentGame(0) instanceof LeagueWrap\Response\Game);
	}
}

