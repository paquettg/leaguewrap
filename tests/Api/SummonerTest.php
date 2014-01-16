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
		             ->with('na/v1.2/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$this->assertEquals(74602, $bakasan->id);
	}

	public function testInfoId()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info(74602);
		$this->assertEquals('bakasan', $bakasan->name);
	}

	public function testMasteryPages()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/74602/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"pages":[{"id":36712717,"name":"Support","current":true,"talents":[{"id":4212,"name":"Recovery","rank":2},{"id":4353,"name":"Intelligence","rank":3},{"id":4211,"name":"Block","rank":2},{"id":4311,"name":"Phasewalker","rank":1},{"id":4362,"name":"Wanderer","rank":1},{"id":4312,"name":"Fleet of Foot","rank":2},{"id":4322,"name":"Summoner\'s Insight","rank":3},{"id":4334,"name":"Culinary Master","rank":1},{"id":4344,"name":"Inspiration","rank":2},{"id":4352,"name":"Bandit","rank":1},{"id":4222,"name":"Veteran\'s Scars","rank":3},{"id":4314,"name":"Scout","rank":1},{"id":4221,"name":"Unyielding","rank":1},{"id":4331,"name":"Greed","rank":3},{"id":4324,"name":"Alchemist","rank":1},{"id":4232,"name":"Juggernaut","rank":1},{"id":4342,"name":"Wealth","rank":1},{"id":4341,"name":"Scavenger","rank":1}]},{"id":36712718,"name":"AP","current":false,"talents":[{"id":4212,"name":"Recovery","rank":2},{"id":4211,"name":"Block","rank":2},{"id":4124,"name":"Feast","rank":1},{"id":4154,"name":"Arcane Blade","rank":1},{"id":4114,"name":"Butcher","rank":1},{"id":4222,"name":"Veteran\'s Scars","rank":3},{"id":4113,"name":"Sorcery","rank":4},{"id":4221,"name":"Unyielding","rank":1},{"id":4152,"name":"Devastating Strikes","rank":3},{"id":4123,"name":"Mental Force","rank":3},{"id":4111,"name":"Double-Edged Sword","rank":1},{"id":4134,"name":"Executioner","rank":2},{"id":4133,"name":"Arcane Mastery","rank":1},{"id":4232,"name":"Juggernaut","rank":1},{"id":4143,"name":"Archmage","rank":3},{"id":4162,"name":"Havoc","rank":1}]}]}');

		$api = new Api('key', $this->client);
		$masteryPages = $api->summoner()->masteryPages(74602);
		$masteryPage = $masteryPages[0];
		$this->assertTrue($masteryPage instanceof LeagueWrap\Response\MasteryPage);
	}

	public function testMasteryPagesSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/74602/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"pages":[{"id":36712717,"name":"Support","current":true,"talents":[{"id":4212,"name":"Recovery","rank":2},{"id":4353,"name":"Intelligence","rank":3},{"id":4211,"name":"Block","rank":2},{"id":4311,"name":"Phasewalker","rank":1},{"id":4362,"name":"Wanderer","rank":1},{"id":4312,"name":"Fleet of Foot","rank":2},{"id":4322,"name":"Summoner\'s Insight","rank":3},{"id":4334,"name":"Culinary Master","rank":1},{"id":4344,"name":"Inspiration","rank":2},{"id":4352,"name":"Bandit","rank":1},{"id":4222,"name":"Veteran\'s Scars","rank":3},{"id":4314,"name":"Scout","rank":1},{"id":4221,"name":"Unyielding","rank":1},{"id":4331,"name":"Greed","rank":3},{"id":4324,"name":"Alchemist","rank":1},{"id":4232,"name":"Juggernaut","rank":1},{"id":4342,"name":"Wealth","rank":1},{"id":4341,"name":"Scavenger","rank":1}]},{"id":36712718,"name":"AP","current":false,"talents":[{"id":4212,"name":"Recovery","rank":2},{"id":4211,"name":"Block","rank":2},{"id":4124,"name":"Feast","rank":1},{"id":4154,"name":"Arcane Blade","rank":1},{"id":4114,"name":"Butcher","rank":1},{"id":4222,"name":"Veteran\'s Scars","rank":3},{"id":4113,"name":"Sorcery","rank":4},{"id":4221,"name":"Unyielding","rank":1},{"id":4152,"name":"Devastating Strikes","rank":3},{"id":4123,"name":"Mental Force","rank":3},{"id":4111,"name":"Double-Edged Sword","rank":1},{"id":4134,"name":"Executioner","rank":2},{"id":4133,"name":"Arcane Mastery","rank":1},{"id":4232,"name":"Juggernaut","rank":1},{"id":4143,"name":"Archmage","rank":3},{"id":4162,"name":"Havoc","rank":1}]}]}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$api->summoner()->masteryPages($bakasan);
		$this->assertTrue($bakasan->masteryPage(0) instanceof LeagueWrap\Response\MasteryPage);
	}
}
