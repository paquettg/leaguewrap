<?php

use LeagueWrap\Api;

class ApiLeagueTest extends PHPUnit_Framework_TestCase {

	protected $league;

	protected $summoner;

	public function setUp()
	{
		$key = trim(file_get_contents('tests/key.txt'));
		$api = new Api($key);
		$this->league = $api->league();
		$this->summoner = $api->summoner();
	}

	public function testLeague()
	{
		$leagues = $this->league->league(74602);
		$this->assertEquals(1, count($leagues));
	}

	public function testLeagueSummoner()
	{
		$this->summoner->info('bakasan');
		$this->league->league($this->summoner->bakasan);
		$this->assertTrue($this->summoner->bakasan->league('bakasan') instanceof LeagueWrap\Response\League);
	}
}
