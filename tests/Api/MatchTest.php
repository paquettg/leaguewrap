<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiMatchTest extends PHPUnit_Framework_TestCase
{

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
        $this->assertTrue($match->teams[0] instanceof LeagueWrap\Dto\MatchTeam);
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
        $this->assertTrue($match->teams[0]->bans[0] instanceof LeagueWrap\Dto\Ban);
    }


} 