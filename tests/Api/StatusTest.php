<?php

use LeagueWrap\Api;
use Mockery as m;

class StatusTest extends PHPUnit_Framework_TestCase {

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

	public function testGetShards() {
		$this->client->shouldReceive('baseUrl')
			->with('http://status.leagueoflegends.com/')
			->once();
		$this->client->shouldReceive('request')
			->with('shards', [
				'api_key' => 'key',
			])->once()
			->andReturn(file_get_contents('tests/Json/shards.json'));

		$api   = new Api('key', $this->client);
		$shardlist = $api->status()->shards();

		$this->assertTrue($shardlist instanceof \LeagueWrap\Dto\ShardList);
		$this->assertEquals('na', $shardlist[0]->slug);
	}

	public function testGetShardStatusWithRegion() {
		$this->client->shouldReceive('baseUrl')
			->with('http://status.leagueoflegends.com/')
			->once();
		$this->client->shouldReceive('request')
			->with('shards/euw', [
				'api_key' => 'key',
			])->once()
			->andReturn(file_get_contents('tests/Json/shardstatus.euw.json'));

		$api   = new Api('key', $this->client);
		$api->setRegion('na');
		$shardStatus = $api->status()->shardStatus('euw');

		$this->assertTrue($shardStatus instanceof \LeagueWrap\Dto\ShardStatus);
		$this->assertTrue(sizeof($shardStatus->getService('Game')->incidents) > 0);
	}

	public function testGetShardStatus() {
		$this->client->shouldReceive('baseUrl')
			->with('http://status.leagueoflegends.com/')
			->once();
		$this->client->shouldReceive('request')
			->with('shards/euw', [
				'api_key' => 'key',
			])->once()
			->andReturn(file_get_contents('tests/Json/shardstatus.euw.json'));

		$api   = new Api('key', $this->client);
		$api->setRegion('euw');
		$shardStatus = $api->status()->shardStatus();

		$this->assertTrue($shardStatus instanceof \LeagueWrap\Dto\ShardStatus);
	}

}