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
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.1/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api = new LeagueWrap\Api('key', $this->client);
		$api->limit(1, 10, $this->limit1);
		$champion = $api->champion();
		$champion->free();
		$e = null;
		try
		{
			$champion->free();
		}
		catch(LeagueWrap\Limit\LimitReachedException $e) {}

		$this->assertTrue($e instanceof LeagueWrap\Limit\LimitReachedException);
	}

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
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::limit(1, 10, $this->limit1);
		Summoner::info('bakasan');
		try
		{
			Summoner::info('bakasan');
		}
		catch(LeagueWrap\Limit\LimitReachedException $e) {}

		$this->assertTrue($e instanceof LeagueWrap\Limit\LimitReachedException);
	}

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
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.1/champion', [
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
		$e = null;
		try
		{
			$champion->free();
		}
		catch(LeagueWrap\Limit\LimitReachedException $e) {}

		$this->assertTrue($e instanceof LeagueWrap\Limit\LimitReachedException);
	}
}
