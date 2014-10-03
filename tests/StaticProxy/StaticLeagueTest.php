<?php

use Mockery as m;

class StaticProxyStaticLeagueTest extends PHPUnit_Framework_TestCase {

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

	public function testLeague()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.5/league/by-summoner/272354', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/league.272354.json'));

		Api::setKey('key', $this->client);
		$leagues = League::league(272354);
		$this->assertTrue($leagues[0] instanceof LeagueWrap\Dto\League);
	}
}
