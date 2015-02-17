<?php

use Mockery as m;

class StaticProxyStaticTeamTest extends PHPUnit_Framework_TestCase {

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

	public function testTeam()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.4/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.492066.json'));

		Api::setKey('key', $this->client);
		$teams = Team::team(492066);
		$this->assertEquals('C9', $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa']->tag);
	}

	/**
	 * @expectedException LeagueWrap\Exception\ListMaxException
	 */
	public function testTeamListMaxException()
	{
		Api::setKey('key', $this->client);
		Team::team([
			0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
			10, 11, 12,
		]);
	}
}
