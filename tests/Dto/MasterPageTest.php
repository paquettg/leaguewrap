<?php

class DtoMasteryPageTest extends PHPUnit_Framework_TestCase {

	public function testMastery()
	{
		$masteryPage = new LeagueWrap\Dto\MasteryPage([
			'masteries' => [
				1 => 'mastery1',
				2 => 'mastery2',
				3 => 'mastery3',
			],
		]);

		$mastery = $masteryPage->mastery(3);
		$this->assertEquals('mastery3', $mastery);
	}

	public function testMasteryNotFound()
	{
		$masteryPage = new LeagueWrap\Dto\MasteryPage([
			'masteries' => [
				1 => 'mastery1',
				2 => 'mastery2',
				3 => 'mastery3',
			],
		]);

		$mastery = $masteryPage->mastery(5);
		$this->assertTrue(is_null($mastery));
	}

	public function testNoMasteryProperty()
	{
		$masteryPage = new LeagueWrap\Dto\MasteryPage([]);

		$mastery = $masteryPage->mastery(1);
		$this->assertTrue(is_null($mastery));
	}
}

