<?php

use LeagueWrap\Api;
use Mockery as m;

class CurrentGameTest extends PHPUnit_Framework_TestCase
{

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

	public function testCurrentGame()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
			         ->with('consumer/getSpectatorGameInfo/EUW1/30447079', [
						'api_key' => 'key',
			         ])->once()
			         ->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$game = $api->currentGame()->currentGame(30447079);
		$this->assertTrue($game instanceof LeagueWrap\Dto\CurrentGame);
	}

	public function testCurrentGameGetBan()
	{
		$this->client->shouldReceive('baseUrl')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('consumer/getSpectatorGameInfo/EUW1/30447079', [
						'api_key' => 'key',
			         ])->once()
			         ->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$game = $api->currentGame()->currentGame(30447079);

		$ban = $game->ban(1);
		$this->assertTrue($ban instanceof \LeagueWrap\Dto\Ban);
		$this->assertTrue($ban->teamId == 100);
		$this->assertTrue($ban->championId == 59);

		$noBan = $game->ban(900);
		$this->assertTrue(is_null($noBan));
	}

	public function testCurrentGameObserver()
	{
		$this->client->shouldReceive('baseUrl')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('consumer/getSpectatorGameInfo/EUW1/30447079', [
						'api_key' => 'key',
			         ])->once()
			         ->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$game = $api->currentGame()->currentGame(30447079);

		$this->assertTrue($game->observers instanceof \LeagueWrap\Dto\Observer);
		$this->assertTrue($game->observers->encryptionKey == "02PHNRQw/YzBA35fF/LMVao8ui8A7pnz");
	}

	public function testCurrentGameParticipant()
	{
		$this->client->shouldReceive('baseUrl')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('consumer/getSpectatorGameInfo/EUW1/30447079', [
						'api_key' => 'key',
			         ])->once()
			         ->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$game = $api->currentGame()->currentGame(30447079);

		$this->assertTrue($game->participant(30447079) instanceof \LeagueWrap\Dto\CurrentGameParticipant);
	}

	public function testCurrentGameParticipantMasteries()
	{
		$this->client->shouldReceive('baseUrl')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('consumer/getSpectatorGameInfo/EUW1/30447079', [
						'api_key' => 'key',
			         ])->once()
			         ->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$game = $api->currentGame()->currentGame(30447079);

		$participant = $game->participant(28882300);
		$this->assertTrue($participant->mastery(4132) instanceof \LeagueWrap\Dto\Mastery);
		$this->assertTrue($participant->mastery(4132)->rank == 1);
	}

	public function testCurrentGameParticipantRunes()
	{
		$this->client->shouldReceive('baseUrl')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('consumer/getSpectatorGameInfo/EUW1/30447079', [
						'api_key' => 'key',
			         ])->once()
			         ->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$game = $api->currentGame()->currentGame(30447079);

		$participant = $game->participant(28882300);
		$this->assertTrue($participant->rune(5253) instanceof \LeagueWrap\Dto\Rune);
		$this->assertTrue($participant->rune(5253)->count == 9);
	}
}
