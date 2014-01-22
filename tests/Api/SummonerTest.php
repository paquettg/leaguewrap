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
		             ->with('na/v1.3/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"bakasan":{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1390057239000}}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$this->assertEquals(74602, $bakasan->id);
	}

	public function testInfoId()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"74602":{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1390057239000}}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info(74602);
		$this->assertEquals('bakasan', $bakasan->name);
	}

	public function testInfoMixed()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"bakasan":{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1390057239000}}');
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/7024,97235', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"97235":{"id":97235,"name":"IS1c2d27157a9df3f5aef47","profileIconId":10,"summonerLevel":1,"revisionDate":1371607602000},"7024":{"id":7024,"name":"Jigsaw","profileIconId":27,"summonerLevel":30,"revisionDate":1390138283000}}');

		$api = new Api('key', $this->client);
		$summoners = $api->summoner()->info([
			'bakasan',
			7024,
			97235,
		]);
		$this->assertTrue(isset($summoners['IS1c2d27157a9df3f5aef47']));
	}

	public function testName()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/74602/name', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"74602":"bakasan"}');

		$api = new Api('key', $this->client);
		$names = $api->summoner()->name(74602);
		$this->assertEquals('bakasan', $names[74602]);
	}

	public function testNameArray()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/74602,7024,97235/name', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"97235":"IS1c2d27157a9df3f5aef47","7024":"Jigsaw","74602":"bakasan"}');

		$api = new Api('key', $this->client);
		$names = $api->summoner()->name([
			74602,
			7024,
			97235,
		]);
		$this->assertEquals('Jigsaw', $names[7024]);
	}
}
