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
		             ->with(1, 10, 'na')
		             ->andReturn(true);
		$this->limit1->shouldReceive('hit')
		             ->twice()
		             ->with(1)
		             ->andReturn(true, false);
		$this->limit1->shouldReceive('isValid')
		             ->once()
		             ->andReturn(true);
		$this->limit1->shouldReceive('getRegion')
		             ->twice()
		             ->andReturn('na');
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api = new LeagueWrap\Api('key', $this->client);
		$api->limit(1, 10, 'na', $this->limit1);
		$champion = $api->champion();
		$champion->free();
		$champion->free();
	}

	/**
	 * @expectedException LeagueWrap\Exception\LimitReachedException
	 */
	public function testSingleFileLimit()
	{
		$this->limit1->shouldReceive('isValid')
		             ->once()
		             ->andReturn(false);
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api = new LeagueWrap\Api('key', $this->client);
		$api->limit(1, 10, 'na', $this->limit1);
		$champion = $api->champion();
		$champion->free();
		$champion->free();
	}

	/**
	 * @expectedException LeagueWrap\Exception\LimitReachedException
	 */
	public function testSingleLimitStaticProxy()
	{
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(1, 10, 'na')
		             ->andReturn(true);
		$this->limit1->shouldReceive('hit')
		             ->twice()
		             ->with(1)
		             ->andReturn(true, false);
		$this->limit1->shouldReceive('isValid')
		             ->once()
		             ->andReturn(true);
		$this->limit1->shouldReceive('getRegion')
		             ->twice()
		             ->andReturn('na');
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		LeagueWrap\StaticApi::mount();
		Api::setKey('key', $this->client);
		Api::limit(1, 10, 'na', $this->limit1);
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
		             ->with(5, 10, 'na')
		             ->andReturn(true);
		$this->limit1->shouldReceive('hit')
		             ->times(3)
		             ->with(1)
		             ->andReturn(true);
		$this->limit1->shouldReceive('isValid')
		             ->once()
		             ->andReturn(true);
		$this->limit1->shouldReceive('getRegion')
		             ->times(3)
		             ->andReturn('na');
		$this->limit2->shouldReceive('setRate')
		             ->once()
		             ->with(2, 5, 'na')
		             ->andReturn(true);
		$this->limit2->shouldReceive('hit')
		             ->times(3)
		             ->with(1)
		             ->andReturn(true, true, false);
		$this->limit2->shouldReceive('isValid')
		             ->once()
		             ->andReturn(true);
		$this->limit2->shouldReceive('getRegion')
		             ->times(3)
		             ->andReturn('na');
		$this->client->shouldReceive('baseUrl')
		             ->times(3);
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->twice()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api = new LeagueWrap\Api('key', $this->client);
		$api->limit(5, 10, 'na', $this->limit1);
		$api->limit(2, 5, 'na', $this->limit2);
		$champion = $api->champion();
		$champion->free();
		$champion->free();
		$champion->free();
	}

	public function testAllRegionsLimit()
	{
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'br')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'eune')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'euw')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'kr')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'lan')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'las')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'na')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'oce')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'ru')
		             ->andReturn(true);
		$this->limit1->shouldReceive('setRate')
		             ->once()
		             ->with(10, 5, 'tr')
		             ->andReturn(true);
		$this->limit1->shouldReceive('hit')
		             ->once()
		             ->with(1)
		             ->andReturn(true);
		$this->limit1->shouldReceive('isValid')
		             ->once()
		             ->andReturn(true);
		$this->limit1->shouldReceive('getRegion')
		             ->times(10)
		             ->andReturn('br', 'eune', 'euw', 'kr', 'lan', 'las', 'na', 'oce', 'ru', 'tr');
		$this->limit1->shouldReceive('newInstance')
		             ->times(10)
		             ->andReturn($this->limit1);
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api = new LeagueWrap\Api('key', $this->client);
		$api->limit(10, 5, 'all', $this->limit1);
		$champion = $api->champion();
		$info = $champion->free();
		$this->assertTrue(is_array($info->champions));
	}
}
