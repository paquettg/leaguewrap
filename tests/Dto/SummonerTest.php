<?php

class DtoSummonerTest extends PHPUnit_Framework_TestCase {

	public function testRunePage()
	{
		$summoner = new LeagueWrap\Dto\Summoner([
			'runePages' => [
				1 => 'runePage1',
				2 => 'runePage2',
				3 => 'runePage3',
			],
		]);

		$runePage = $summoner->runePage(2);
		$this->assertEquals('runePage2', $runePage);
	}

	public function testRunePageNotFound()
	{
		$summoner = new LeagueWrap\Dto\Summoner([
			'runePages' => [
				1 => 'runePage1',
				2 => 'runePage2',
				3 => 'runePage3',
			],
		]);

		$runePage = $summoner->runePage(5);
		$this->assertTrue(is_null($runePage));
	}

	public function testNoRunePages()
	{
		$summoner = new LeagueWrap\Dto\Summoner([]);

		$runePage = $summoner->runePage(1);
		$this->assertTrue(is_null($runePage));
	}

	public function testMasteryPage()
	{
		$summoner = new LeagueWrap\Dto\Summoner([
			'masteryPages' => [
				1 => 'masteryPage1',
				2 => 'masteryPage2',
				3 => 'masteryPage3',
			],
		]);

		$masteryPage = $summoner->masteryPage(2);
		$this->assertEquals('masteryPage2', $masteryPage);
	}

	public function testMasteryPageNotFound()
	{
		$summoner = new LeagueWrap\Dto\Summoner([
			'masteryPages' => [
				1 => 'masteryPage1',
				2 => 'masteryPage2',
				3 => 'masteryPage3',
			],
		]);

		$masteryPage = $summoner->masteryPage(5);
		$this->assertTrue(is_null($masteryPage));
	}

	public function testNoMasteryPages()
	{
		$summoner = new LeagueWrap\Dto\Summoner([]);

		$masteryPage = $summoner->masteryPage(1);
		$this->assertTrue(is_null($masteryPage));
	}

	public function testNoRecentGames()
	{
		$summoner = new LeagueWrap\Dto\Summoner([]);

		$recentGame = $summoner->recentGame(1);
		$this->assertTrue(is_null($recentGame));
	}
}
