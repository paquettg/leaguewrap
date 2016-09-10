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
		$this->client->shouldReceive('baseUrl')->with('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/')
		             ->once();
		$this->client->shouldReceive('request')
			         ->with('30447079', [
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
		$this->client->shouldReceive('baseUrl')->with('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('30447079', [
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
		$this->client->shouldReceive('baseUrl')->with('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('30447079', [
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
		$this->client->shouldReceive('baseUrl')->with('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('30447079', [
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
		$this->client->shouldReceive('baseUrl')->with('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('30447079', [
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
		$this->client->shouldReceive('baseUrl')->with('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/')
			         ->once();
		$this->client->shouldReceive('request')
			         ->with('30447079', [
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

	public function testAttachStaticData()
	{
		$this->client->shouldReceive('baseUrl')->with('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/')
			         ->once();
		$this->client->shouldReceive('baseUrl')->with('https://global.api.pvp.net/api/lol/static-data/euw/')
			->times(4);

		$this->client->shouldReceive('request')
			         ->with('30447079', [
						'api_key' => 'key',
			         ])->once()
			         ->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));
		$this->client->shouldReceive('request')
		             ->with('v1.2/champion', [
						'api_key'  => 'key',
						'dataById' => 'true',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/champion.euw.json'));
		$this->client->shouldReceive('request')
		             ->with('v1.2/summoner-spell', [
						'api_key'  => 'key',
						'dataById' => 'true',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/summonerspell.euw.json'));
		$this->client->shouldReceive('request')
		             ->with('v1.2/mastery', [
						'api_key'  => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/mastery.euw.json'));
		$this->client->shouldReceive('request')
		             ->with('v1.2/rune', [
						'api_key'  => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/rune.euw.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$api->attachStaticData(true);
		$game = $api->currentGame()->currentGame(30447079);

		$participant = $game->participant(28882300);
		$rune = $participant->rune(5253);
		$this->assertTrue($rune->runeStaticData instanceof LeagueWrap\Dto\StaticData\Rune);
		$masteries = $participant->masteries;
		$this->assertTrue($masteries[6111]->masteryStaticData instanceof LeagueWrap\Dto\StaticData\Mastery);
	}
}
