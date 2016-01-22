<?php


use LeagueWrap\Dto\Shard;
use LeagueWrap\Dto\ShardList;

class ShardListTest extends PHPUnit_Framework_TestCase
{

	public function testCreateShards() {
		$shardlist = new ShardList([
			[], []
		]);
		$this->assertEquals(2, sizeof($shardlist));
		$this->assertTrue($shardlist[0] instanceof Shard);
	}

	public function testCreateEmptyList() {
		$shardlist = new ShardList([]);
		$this->assertEquals(0, sizeof($shardlist));
	}

	public function testGetShardByRegion() {
		$shardlist = new ShardList([
			[
				'slug' => 'euw',
				'hostname' => 'prod.euw1.lol.riotgames.com'
			],
			[
				'slug' => 'na',
				'hostname' => 'prod.na1.lol.riotgames.com'
			]
		]);
		$shard = $shardlist->getShardByRegion("euw");
		$this->assertEquals('prod.euw1.lol.riotgames.com', $shard->hostname);

		$this->assertNull($shardlist->getShardByRegion("asdasd"));
	}

}