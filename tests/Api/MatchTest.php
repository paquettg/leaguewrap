<?php

use LeagueWrap\Api;
use LeagueWrap\Dto\MatchTimeline;
use Mockery as m;

class ApiMatchTest extends PHPUnit_Framework_TestCase {

	protected $client;

	public function setUp()
	{
		$client		  = m::mock('LeagueWrap\Client');
		$this->client = $client;
	}

	public function tearDown()
	{
		m::close();
	}

	public function testMatch()
	{
		$this->client->shouldReceive('baseUrl')
			->once();
		$this->client->shouldReceive('request')
			->with('na/v2.2/match/1399898747', [
				'api_key' => 'key',
			])->once()
			->andReturn(file_get_contents('tests/Json/matchhistory.match.1399898747.json'));

		$api   = new Api('key', $this->client);
		$match = $api->match()->match(1399898747);
		$this->assertTrue($match instanceof LeagueWrap\Dto\Match);
	}

	public function testMatchWithStatic()
	{
		$this->client->shouldReceive('baseUrl')
					 ->times(4);
		$this->client->shouldReceive('request')
					 ->with('na/v2.2/match/1399898747', [
						'api_key' => 'key',
					 ])->once()
					 ->andReturn(file_get_contents('tests/Json/matchhistory.match.1399898747.json'));
		$this->client->shouldReceive('request')
					 ->with('na/v1.2/champion', [
						'api_key'  => 'key',
						'dataById' => 'true',
					 ])->once()
					 ->andReturn(file_get_contents('tests/Json/Static/champion.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner-spell', [
						'api_key'  => 'key',
						'dataById' => 'true',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/summonerspell.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/item', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/items.json'));

		$api = new Api('key', $this->client);
		$api->attachStaticData();
		$match = $api->match()->match(1399898747);
		$this->assertEquals('LeBlanc', $match->team(0)->ban(0)->championStaticData->name);
	}

	public function testTeams()
	{
		$this->client->shouldReceive('baseUrl')
			->once();
		$this->client->shouldReceive('request')
			->with('na/v2.2/match/1399898747', [
				'api_key' => 'key',
			])->once()
			->andReturn(file_get_contents('tests/Json/matchhistory.match.1399898747.json'));

		$api   = new Api('key', $this->client);
		$match = $api->match()->match(1399898747);
		$this->assertTrue($match->team(0) instanceof LeagueWrap\Dto\MatchTeam);
	}

	public function testBans()
	{
		$this->client->shouldReceive('baseUrl')
			->once();
		$this->client->shouldReceive('request')
			->with('na/v2.2/match/1399898747', [
				'api_key' => 'key',
			])->once()
			->andReturn(file_get_contents('tests/Json/matchhistory.match.1399898747.json'));

		$api   = new Api('key', $this->client);
		$match = $api->match()->match(1399898747);
		$this->assertTrue($match->team(0)->ban(0) instanceof LeagueWrap\Dto\Ban);
	}

	public function testIncludeTimeline()
	{
		$this->client->shouldReceive('baseUrl')
			->once();
		$this->client->shouldReceive('request')
			->with('na/v2.2/match/1399898747', [
				'api_key' => 'key',
				'includeTimeline' => true
			])->once()
			->andReturn(file_get_contents('tests/Json/matchhistory.match.1399898747.timeline.json'));

		$api   = new Api('key', $this->client);
		$match = $api->match()->match(1399898747, true);
		$this->assertTrue($match instanceof LeagueWrap\Dto\Match);
	}

	public function testTimeline()
	{
		$this->client->shouldReceive('baseUrl')
			->once();
		$this->client->shouldReceive('request')
			->with('na/v2.2/match/1399898747', [
				'api_key' => 'key',
				'includeTimeline' => true
			])->once()
			->andReturn(file_get_contents('tests/Json/matchhistory.match.1399898747.timeline.json'));

		$api   = new Api('key', $this->client);
		$match = $api->match()->match(1399898747, true);
		$this->assertTrue($match->timeline instanceof MatchTimeline);
	}

	public function testTimelineFrame()
	{
		$this->client->shouldReceive('baseUrl')
			->once();
		$this->client->shouldReceive('request')
			->with('na/v2.2/match/1399898747', [
				'api_key' => 'key',
				'includeTimeline' => true
			])->once()
			->andReturn(file_get_contents('tests/Json/matchhistory.match.1399898747.timeline.json'));

		$api   = new Api('key', $this->client);
		$match = $api->match()->match(1399898747, true);

		$frame = $match->timeline->frames[1];
		$this->assertTrue($frame instanceof LeagueWrap\Dto\TimelineFrame);
		$this->assertTrue($frame->participantFrame(1) instanceof LeagueWrap\Dto\TimelineParticipantFrame);
		$this->assertTrue($frame->events[0] instanceof LeagueWrap\Dto\TimelineFrameEvent);
	}
} 
