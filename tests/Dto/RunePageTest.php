<?php

class DtoRunePageTest extends PHPUnit_Framework_TestCase {

	public function testRune()
	{
		$runePage = new LeagueWrap\Dto\RunePage([
			'runes' => [
				1 => 'rune1',
				2 => 'rune2',
				3 => 'rune3',
			],
		]);

		$rune = $runePage->rune(3);
		$this->assertEquals('rune3', $rune);
	}

	public function testRuneNotFound()
	{
		$runePage = new LeagueWrap\Dto\RunePage([
			'runes' => [
				1 => 'rune1',
				2 => 'rune2',
				3 => 'rune3',
			],
		]);

		$rune = $runePage->rune(5);
		$this->assertTrue(is_null($rune));
	}

	public function testNoRuneProperty()
	{
		$runePage = new LeagueWrap\Dto\RunePage([]);

		$rune = $runePage->rune(1);
		$this->assertTrue(is_null($rune));
	}
}
