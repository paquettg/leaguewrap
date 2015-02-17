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
		             ->with('na/v2.4/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.492066.json'));

		$api   = new Api('key', $this->client);
		$teams = $api->team()->team(492066);
		$this->assertEquals('C9', $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa']->tag);
	}

	/**
	 * @expectedException LeagueWrap\Exception\ListMaxException
	 */
	public function testTeamListMaxException()
	{
		$api   = new Api('key', $this->client);
		$teams = $api->team()->team([
			0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
			10, 11, 12,
		]);
	}

	public function testTeamArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.4/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.492066.json'));

		$api   = new Api('key', $this->client);
		$teams = $api->team()->team(492066);
		$c9    = $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
		$this->assertTrue($c9[0] instanceof LeagueWrap\Dto\Team\Match);
	}

	public function testTeamRosterArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.4/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.492066.json'));

		$api   = new Api('key', $this->client);
		$teams = $api->team()->team(492066);
		$c9    = $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
		$this->assertTrue($c9->roster[19302712] instanceof LeagueWrap\Dto\Team\Member);
	}

	public function testTeamSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v2.4/team/by-summoner/492066', [
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
		             ->with('na/v2.4/team/by-summoner/492066', [
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

	public function testTeamMultiple()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.4/team/by-summoner/18991200,492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.18991200.492066.json'));

		$api   = new Api('key', $this->client);
		$teams = $api->team()->team([
			18991200,
			492066,
		]);
		$this->assertTrue($teams[18991200]['TEAM-00e058f0-bb04-46c5-bac1-07cebcc1cef1'] instanceof LeagueWrap\Dto\Team);
	}

	public function testTeamSummonerMultiple()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/18991200,492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.18991200.492066.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v2.4/team/by-summoner/492066,18991200', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/team.18991200.492066.json'));

		$api = new Api('key', $this->client);
		$summoners = $api->summoner()->info([
			18991200,
			492066,
		]);
		$api->team()->team($summoners);
		$team = $summoners['C9 Hai']->teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
		$this->assertEquals('C9', $team->tag);
	}
}
