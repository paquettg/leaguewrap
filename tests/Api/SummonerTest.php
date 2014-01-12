<?php

use LeagueWrap\Api;

class ApiSummonerTest extends PHPUnit_Framework_TestCase {

	protected $summoner;

	public function setUp()
	{
		$key = trim(file_get_contents('tests/key.txt'));
		$api = new Api($key);
		$this->summoner = $api->summoner();
	}

	public function testInfo()
	{
		$bakasan = $this->summoner->info('bakasan');
		$this->assertEquals(74602, $bakasan->id);
	}

	public function testInfoId()
	{
		$bakasan = $this->summoner->info(74602);
		$this->assertEquals('bakasan', $bakasan->name);
	}

	public function testRunePages()
	{
		$runePages = $this->summoner->runePages(74602);
		$runePage  = $runePages[0];
		$this->assertEquals(30, count($runePage->runes));
	}

	public function testRunePagesSummoner()
	{
		$bakasan = $this->summoner->info('bakasan');
		$this->summoner->runePages($bakasan);
		$this->assertTrue($bakasan->runePage(0) instanceof LeagueWrap\Response\RunePage);
	}

	public function testMasteryPages()
	{
		$masteryPages = $this->summoner->masteryPages(74602);
		$masteryPage  = $masteryPages[0];
		$this->assertTrue($masteryPage instanceof LeagueWrap\Response\MasteryPage);
	}

	public function testMasteryPagesSummoner()
	{
		$bakasan = $this->summoner->info('bakasan');
		$this->summoner->masteryPages($bakasan);
		$this->assertTrue($bakasan->masteryPage(0) instanceof LeagueWrap\Response\MasteryPage);
	}

	public function testAllInfo()
	{
		$bakasan = $this->summoner->allInfo('bakasan');
		$this->assertEquals(3, $this->summoner->getRequestCount());
	}

	public function testAllInfoId()
	{
		$bakasan = $this->summoner->allInfo(74602);
		$this->assertTrue($bakasan->masteryPage(0) instanceof LeagueWrap\Response\MasteryPage);
	}
}
