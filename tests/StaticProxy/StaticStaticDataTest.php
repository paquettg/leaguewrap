<?php

use Mockery as m;

class StaticProxyStaticStaticDataTest extends PHPUnit_Framework_TestCase {

	protected $client;

	public function setUp()
	{
		$this->client = m::mock('LeagueWrap\Client');
		LeagueWrap\StaticApi::mount();
	}

	public function tearDown()
	{
		m::close();
	}

	public function testStaticChampion()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'api_key'  => 'key',
						'dataById' => 'true',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/champion.json'));

		Api::setKey('key', $this->client);
		$champions = StaticData::getChampions();
		$champion  = $champions->getChampion(53);
		$this->assertEquals('Blitzcrank', $champion->name);
	}

	public function testStaticItem()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/item', [
						'api_key' => 'key',
						'locale'  => 'ko_KR',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/items.kr.json'));

		Api::setKey('key', $this->client);
		$items = StaticData::setLocale('ko_KR')
		                     ->getItems();
		$item = $items->getItem(1042);
		$this->assertEquals('단검', $item->name);
	}
}
