<?php

use LeagueWrap\Api;
use Mockery as m;

class StaticRuneTest extends PHPUnit_Framework_TestCase {

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

	public function testGetRuneDefault()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/rune', [
						'api_key'  => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/rune.json'));

		$api   = new Api('key', $this->client);
		$runes = $api->staticData()->getRunes();
		$rune  = $runes->getRune(5129);
		$this->assertEquals('Mark of Critical Chance', $rune->name);
	}

	public function testArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/rune', [
						'api_key'  => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/rune.json'));

		$api   = new Api('key', $this->client);
		$runes = $api->staticData()->getRunes();
		$this->assertEquals('Mark of Critical Chance', $runes[5129]->name);
	}

	public function testGetRuneRegionKR()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('kr/v1.2/rune', [
						'api_key'  => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/rune.kr.json'));

		$api   = new Api('key', $this->client);
		$runes = $api->setRegion('kr')
		             ->staticData()->getRunes();
		$rune  = $runes->getRune(5267);
		$this->assertEquals('상급 주문력 표식', $rune->name);
	}

	public function testGetRuneById()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/rune/5267', [
						'api_key'  => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/rune.5267.json'));

		$api  = new Api('key', $this->client);
		$rune = $api->staticData()->getRune(5267);
		$this->assertEquals('3', $rune->rune->tier);
	}

	public function testGetRuneImage()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/rune/5001', [
						'api_key'  => 'key',
						'runeData' => 'image',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/rune.5001.image.json'));

		$api  = new Api('key', $this->client);
		$rune = $api->staticData()->getRune(5001, 'image');
		$this->assertEquals('r_1_1.png', $rune->image->full);
	}

	public function testGetRuneAll()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/rune', [
						'api_key'      => 'key',
						'runeListData' => 'all',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/rune.all.json'));

		$api   = new Api('key', $this->client);
		$runes = $api->staticData()->getRunes('all');
		$rune  = $runes->getRune(5001);
		$this->assertEquals('0.525', $rune->stats->FlatPhysicalDamageMod);
	}
}
