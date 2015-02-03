<?php

class DtoGameTest extends PHPUnit_Framework_TestCase {

	public function testPlayer()
	{
		$game = new LeagueWrap\Dto\Game([
			'fellowPlayers' => [
				123 => [
					'name' => 'fellowPlayer1',
				],
				245 => [
					'name' => 'fellowPlayer2',
				],
				366 => [
					'name' => 'fellowPlayer3',
				],
			],
		]);

		$player = $game->player(123);
		$this->assertEquals('fellowPlayer1', $player->name);
	}

	public function testPlayerNotFound()
	{
		$game = new LeagueWrap\Dto\Game([
			'fellowPlayers' => [
				123 => [
					'name' => 'fellowPlayer1',
				],
				245 => [
					'name' => 'fellowPlayer2',
				],
				366 => [
					'name' => 'fellowPlayer3',
				],
			],
		]);

		$player = $game->player(1);
		$this->assertTrue(is_null($player));
	}

	public function testNoPlayerProperty()
	{
		$game = new LeagueWrap\Dto\Game([]);

		$player = $game->player(1);
		$this->assertTrue(is_null($player));
	}
}

