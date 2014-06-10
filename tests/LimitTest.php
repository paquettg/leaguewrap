<?php

use Mockery as m;

class LimitTest extends PHPUnit_Framework_TestCase {

	protected $limit1;
	protected $limit2;
	protected $client;

	public function setUp()
	{
		$this->limit1 = m::mock('LeagueWrap\LimitInterface');
		$this->limit2 = m::mock('LeagueWrap\LimitInterface');
		$this->client = m::mock('LeagueWrap\Client');
	}

	public function tearDown()
	{
		m::close();
	}

	/**
	 * @expectedException LeagueWrap\Exception\LimitReachedException
	 */
	public function testSingleLimit()
	{
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(1, 10)
		             ->andReturn(true);
		$this->limit1->shouldReceive('hit')
		             ->twice()
		             ->with(1)
		             ->andReturn(true, false);
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api = new LeagueWrap\Api('key', $this->client);
		$api->limit(1, 10, $this->limit1);
		$champion = $api->champion();
		$champion->free();
		$champion->free();

	}

	/**
	 * @expectedException LeagueWrap\Exception\LimitReachedException
	 */
	public function testSingleLimitFacade()
	{
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(1, 10)
		             ->andReturn(true);
		$this->limit1->shouldReceive('hit')
		             ->twice()
		             ->with(1)
		             ->andReturn(true, false);
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::limit(1, 10, $this->limit1);
		Summoner::info('bakasan');
		Summoner::info('bakasan');
	}

	/**
	 * @expectedException LeagueWrap\Exception\LimitReachedException
	 */
	public function testDoubleLimit()
	{
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(5, 10)
		             ->andReturn(true);
		$this->limit1->shouldReceive('hit')
		             ->times(3)
		             ->with(1)
		             ->andReturn(true);
		$this->limit2->shouldReceive('setRate')
		             ->once()
		             ->with(2, 5)
		             ->andReturn(true);
		$this->limit2->shouldReceive('hit')
		             ->times(3)
		             ->with(1)
		             ->andReturn(true, true, false);
		$this->client->shouldReceive('baseUrl')
		             ->times(3);
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->twice()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api = new LeagueWrap\Api('key', $this->client);
		$api->limit(5, 10, $this->limit1);
		$api->limit(2, 5, $this->limit2);
		$champion = $api->champion();
		$champion->free();
		$champion->free();
		$champion->free();
	}
}
