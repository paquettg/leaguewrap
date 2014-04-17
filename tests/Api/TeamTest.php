<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiTeamTest extends PHPUnit_Framework_TestCase {

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

	public function testTeam()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.492066.json'));

		$api   = new Api('key', $this->client);
		$teams = $api->team()->team(492066);
		$this->assertEquals('C9', $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa']->tag);
	}

	public function testTeamSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.492066.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/C9 Hai', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.c9hai.json'));
		
		$api = new Api('key', $this->client);
		$hai = $api->summoner()->info('C9 Hai');
		$api->team()->team($hai);
		$this->assertTrue($hai->teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'] instanceof LeagueWrap\Dto\Team);
	}

	public function testTeamSummonerMember()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.492066.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/C9 Hai', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.c9hai.json'));
		
		$api  = new Api('key', $this->client);
		$hai  = $api->summoner()->info('C9 Hai');
		$team = $api->team()->team($hai)['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
		$this->assertEquals('MEMBER', $team->roster->member(19302712)->status);
	}
}
