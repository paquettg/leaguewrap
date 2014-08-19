<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiMatchHistoryTest extends PHPUnit_Framework_TestCase {

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

    public function testMatchHistory()
    {
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchhistory/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api   = new Api('key', $this->client);
        $matches = $api->matchHistory()->history(74602);
        $this->assertTrue($matches instanceof LeagueWrap\Dto\MatchHistory);
    }

    public function testMatchHistoryArrayAccess()
    {
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchhistory/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api   = new Api('key', $this->client);
        $matches = $api->matchHistory()->history(74602);
        $this->assertTrue($matches->match(0) instanceof LeagueWrap\Dto\Match);
    }

    public function testHistorySummoner()
    {
        $this->client->shouldReceive('baseUrl')
            ->twice();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchhistory/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));
        $this->client->shouldReceive('request')
            ->with('na/v1.4/summoner/by-name/bakasan', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api     = new Api('key', $this->client);
        $bakasan = $api->summoner()->info('bakasan');
        $matches = $api->matchHistory()->history($bakasan);;
        $this->assertTrue($bakasan->matchhistory->match(0) instanceof LeagueWrap\Dto\Match);
    }


    public function testParticipant()
    {
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchhistory/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api   = new Api('key', $this->client);
        $matches = $api->matchHistory()->history(74602);
        $this->assertEquals(100, $matches->match(0)->participant(0)->teamId);
    }

    public function testParticipantStats()
    {
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchhistory/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api   = new Api('key', $this->client);
        $matches = $api->matchHistory()->history(74602);
        $this->assertEquals(17, $matches->match(0)->participant(0)->stats->champLevel);
//        $this->client->shouldReceive('baseUrl')
//            ->twice();
//        $this->client->shouldReceive('request')
//            ->with('na/v1.3/game/by-summoner/74602/recent', [
//                'api_key' => 'key',
//            ])->once()
//            ->andReturn(file_get_contents('tests/Json/game.recent.74602.json'));
//        $this->client->shouldReceive('request')
//            ->with('na/v1.4/summoner/by-name/bakasan', [
//                'api_key' => 'key',
//            ])->once()
//            ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));
//
//        $api     = new Api('key', $this->client);
//        $bakasan = $api->summoner()->info('bakasan');
//        $games   = $api->game()->recent($bakasan);
//        $game    = $bakasan->recentGame(0);
//        $this->assertEquals(13, $game->stats->level);
    }

    public function testParticipantIdentity()
    {
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchhistory/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchhistory.74602.json'));

        $api   = new Api('key', $this->client);
        $matches = $api->matchHistory()->history(74602);
        $this->assertEquals(0, $matches->match(0)->identity(0)->participantId);
    }
} 