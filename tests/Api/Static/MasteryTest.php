<?php

use LeagueWrap\Api;
use Mockery as m;

class StaticMasteryTest extends PHPUnit_Framework_TestCase
{

	protected $client;

	public function setUp()
	{
		$client = m::mock('LeagueWrap\Client');
		$this->client = $client;
	}

	public function tearDown()
	{
		m::close();
	}

	public function testGetMasteryDefault()
	{
		$this->client->shouldReceive('baseUrl')
				->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery', [
						'api_key' => 'key',
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.json'));

		$api = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries();
		$mastery = $masteries->getMastery(6111);
		$this->assertEquals('Fury', $mastery->name);
	}

	public function testArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
				->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery', [
						'api_key' => 'key',
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.json'));

		$api = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries();
		$this->assertEquals('Fury', $masteries[6111]->name);
	}

	public function testGetMasteryRegionKR()
	{
		$this->client->shouldReceive('baseUrl')
				->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery', [
						'api_key' => 'key',
						'locale' => 'ko_KR',
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.kr.json'));

		$api = new Api('key', $this->client);
		$masteries = $api->staticData()->setLocale('ko_KR')
				->getMasteries();
		$mastery = $masteries->getMastery(6111);
		$this->assertEquals('분노', $mastery->name);
	}

	public function testGetMasteryById()
	{
		$this->client->shouldReceive('baseUrl')
				->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery/6111', [
						'api_key' => 'key',
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.6111.json'));

		$api = new Api('key', $this->client);
		$mastery = $api->staticData()->getMastery(6111);
		$this->assertEquals('Fury', $mastery->name);
	}

	public function testGetMasteryRank()
	{
		$this->client->shouldReceive('baseUrl')
				->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery/6111', [
						'api_key' => 'key',
						'masteryData' => 'ranks',
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.6111.ranks.json'));

		$api = new Api('key', $this->client);
		$mastery = $api->staticData()->getMastery(6111, 'ranks');
		$this->assertEquals(5, $mastery->ranks);
	}

	public function testGetMasteryAll()
	{
		$this->client->shouldReceive('baseUrl')
				->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery', [
						'api_key' => 'key',
						'masteryListData' => 'all',
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.all.json'));

		$api = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries('all');
		$mastery = $masteries->getMastery(6111);
		$this->assertEquals('+1.6% Attack Speed', $mastery->description[1]);
	}

	public function testGetMasteryAsTree()
	{
		$this->client->shouldReceive('baseUrl')->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery', [
						'api_key' => 'key',
						'masteryListData' => 'tree'
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.tree.json'));
		$api = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries('tree');
		$tree = $masteries->tree;
		$this->assertInstanceOf('\LeagueWrap\Dto\StaticData\MasteryTree', $tree);
		$cunningTree = $tree->Cunning;
		$this->assertTrue(is_array($cunningTree));
		$this->assertInstanceOf('\LeagueWrap\Dto\StaticData\MasteryTreeList', $cunningTree[0]);
	}

	public function testGetMasteryAsTreeLegacy()
	{
		$this->client->shouldReceive('baseUrl')->once();
		$this->client->shouldReceive('request')
				->with('na/v1.2/mastery', [
						'api_key' => 'key',
						'masteryListData' => 'all'
				])->once()
				->andReturn(file_get_contents('tests/Json/Static/mastery.2015.all.json'));
		$api = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries('all');
		$tree = $masteries->tree;
		$this->assertInstanceOf('\LeagueWrap\Dto\StaticData\MasteryTree', $tree);
		$defenseTree = $tree->Defense;
		$this->assertTrue(is_array($defenseTree));
		$this->assertInstanceOf('\LeagueWrap\Dto\StaticData\MasteryTreeList', $defenseTree[0]);
	}
}
