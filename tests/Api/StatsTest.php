<?php

use LeagueWrap\Api;

class ApiStatsTest extends PHPUnit_Framework_TestCase {

	protected $stats;

	protected $summoner;

	public function setUp()
	{
		$key = trim(file_get_contents('tests/key.txt'));
		$api = new Api($key);
		$this->stats = $api->stats();
		$this->summoner = $api->summoner();
	}

	public function testSummary()
	{
		$stats = $this->stats->summary(74602);
		$this->assertEquals(7, count($stats));
	}

	public function testSummarySummoner()
	{
		$this->summoner->info('bakasan');
		$this->stats->summary($this->summoner->bakasan);
		$this->assertTrue($this->summoner->bakasan->stats[0] instanceof LeagueWrap\Response\PlayerStats);
	}

	public function testRanked()
	{
		$stats = $this->stats->ranked(74602);
		$this->assertTrue($stats[0] instanceof LeagueWrap\Response\Champion);
	}
}

