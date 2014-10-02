<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiSummonerTest extends PHPUnit_Framework_TestCase {

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

	public function testInfo()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$this->assertEquals(74602, $bakasan->id);
	}

	public function testInfoId()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.74602.json'));

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info(74602);
		$this->assertEquals('bakasan', $bakasan->name);
	}

	public function testInfoMixed()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/7024,97235', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.7024,97235.json'));

		$api = new Api('key', $this->client);
		$summoners = $api->summoner()->info([
			'bakasan',
			7024,
			97235,
		]);
		$this->assertTrue(isset($summoners['IS1c2d27157a9df3f5aef47']));
	}

	public function testInfoDistinguishesBetweenIntegerIdsAndNumericNames()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/1337', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.1337.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.74602.json'));

		$api = new Api('key', $this->client);
		$summoners = $api->summoner()->info([
			'1337',
			74602
		]);
		$this->assertTrue(isset($summoners['bakasan']));
		$this->assertTrue(isset($summoners['1337']));
	}

	public function testName()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/name', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.name.74602.json'));

		$api = new Api('key', $this->client);
		$names = $api->summoner()->name(74602);
		$this->assertEquals('bakasan', $names[74602]);
	}

	public function testNameArray()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602,7024,97235/name', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.name.74602,7024,97235.json'));

		$api = new Api('key', $this->client);
		$names = $api->summoner()->name([
			74602,
			7024,
			97235,
		]);
		$this->assertEquals('Jigsaw', $names[7024]);
	}

	public function testRunes()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/runes', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.runes.74602.json'));

		$api   = new Api('key', $this->client);
		$runes = $api->summoner()->runePages(74602);
		$this->assertTrue($runes[0] instanceof LeagueWrap\Dto\RunePage);
	}

	public function testRuneArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/runes', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.runes.74602.json'));

		$api   = new Api('key', $this->client);
		$runes = $api->summoner()->runePages(74602);
		$this->assertTrue($runes[0][30] instanceof LeagueWrap\Dto\Rune);
	}

	public function testRunesSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/runes', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.runes.74602.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.74602.json'));

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info(74602);
		$api->summoner()->runePages($bakasan);
		$this->assertEquals(5317, $bakasan->runePage(1)->rune(15)->runeId);
	}

	public function testRunesSummonerArray()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/97235,7024/runes', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.runes.7024,97235.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/7024,97235', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.7024,97235.json'));

		$api = new Api('key', $this->client);
		$summoners = $api->summoner()->info([
			7024,
			97235,
		]);
		$api->summoner()->runePages($summoners);
		$this->assertEquals(0, count($summoners['IS1c2d27157a9df3f5aef47']->runePage(1)->runes));
	}

	public function testMasteries()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.masteries.74602.json'));

		$api       = new Api('key', $this->client);
		$masteries = $api->summoner()->masteryPages(74602);
		$this->assertTrue($masteries[0] instanceof LeagueWrap\Dto\MasteryPage);
	}

	public function testMasteriesArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.masteries.74602.json'));

		$api       = new Api('key', $this->client);
		$masteries = $api->summoner()->masteryPages(74602);
		$this->assertTrue($masteries[0][4342] instanceof LeagueWrap\Dto\Mastery);
	}

	public function testMasteriesArrayOnlyOneMasterySummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('br/v1.4/summoner/401129,1234567823/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.masteries.401129.1234567823.br.json'));

		$api        = new api('key', $this->client);
		$masteries  = $api->setRegion('BR')->summoner()->masteryPages([401129, 1234567823]);
		$this->assertTrue(is_array($masteries[401129]));
	}

	public function testMasteriesSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.masteries.74602.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.74602.json'));

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info(74602);
		$api->summoner()->masteryPages($bakasan);
		$this->assertEquals(2, $bakasan->masteryPage(1)->mastery(4212)->rank);
	}

	public function testMasteriesSummonerArray()
	{
		$this->client->shouldReceive('baseUrl')
		             ->times(2);
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/97235,7024/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.masteries.7024,97235.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/7024,97235', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.7024,97235.json'));

		$api = new Api('key', $this->client);
		$summoners = $api->summoner()->info([
			7024,
			97235,
		]);
		$api->summoner()->masteryPages($summoners);
		$this->assertEquals(0, count($summoners['IS1c2d27157a9df3f5aef47']->masteryPages));
	}
}
