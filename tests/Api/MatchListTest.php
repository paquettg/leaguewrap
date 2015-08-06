<?php

use LeagueWrap\Api;
use Mockery as m;

class MatchListTest extends PHPUnit_Framework_TestCase {

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

    public function testMatchList()
    {
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchlist/by-summoner/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchlist.74602.json'));

        $api   = new Api('key', $this->client);
        $matches = $api->matchlist()->matchlist(74602);
        $this->assertTrue($matches instanceof LeagueWrap\Dto\MatchList);
        $this->assertTrue($matches->totalGames == 2);
        $this->assertTrue($matches->startIndex == 0);
        $this->assertTrue($matches->endIndex == $matches->totalGames);
    }

    public function testMatchListArrayAccess()
    {
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchlist/by-summoner/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchlist.74602.json'));

        $api   = new Api('key', $this->client);
        $matchList = $api->matchlist()->matchlist(74602);
        $this->assertTrue($matchList->match(0) instanceof LeagueWrap\Dto\MatchReference);
    }

    public function testListSummoner()
    {
        $this->client->shouldReceive('baseUrl')
            ->twice();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchlist/by-summoner/74602', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchlist.74602.json'));
        $this->client->shouldReceive('request')
            ->with('na/v1.4/summoner/by-name/bakasan', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api     = new Api('key', $this->client);
        $bakasan = $api->summoner()->info('bakasan');
        $matchList = $api->matchlist()->matchlist($bakasan);;
        $this->assertTrue($bakasan->matchlist->match(0) instanceof LeagueWrap\Dto\MatchReference);
    }

    public function testListWithParams()
    {
        $startTime = 1283846202;
        $endTime = 1283846202 + 1000;
        $this->client->shouldReceive('baseUrl')
            ->once();
        $this->client->shouldReceive('request')
            ->with('na/v2.2/matchlist/by-summoner/74602', [
                'api_key' => 'key',
                'rankedQueues' => 'RANKED_SOLO_5x5',
                'seasons' => 'SEASON2015',
                'championIds' => '1,2,3',
                'beginIndex' => 1,
                'endIndex' => 4,
                'beginTime' => $startTime,
                'endTime' => $endTime
            ])->once()
            ->andReturn(file_get_contents('tests/Json/matchlist.74602.json'));

        $api   = new Api('key', $this->client);
        $matchList = $api->matchlist()->matchlist(74602, 'RANKED_SOLO_5x5', 'SEASON2015', [1,2,3], 1, 4, $startTime, $endTime);
        $this->assertTrue($matchList->match(0) instanceof LeagueWrap\Dto\MatchReference);
    }

    public function testParseParams()
    {
        $class = new ReflectionClass('LeagueWrap\Api\MatchList');
        $method = $class->getMethod('parseParams');
        $method->setAccessible(true);

        $matchApi = (new Api('key', $this->client))->matchList();

        $expected = [
            'rankedQueues' => 'RANKED_SOLO_5x5,RANKED_TEAM_3x3',
            'seasons' => 'SEASON2015',
            'championIds' => '1,2,3',
            'beginIndex' => 1,
        ];

        $result = $method->invoke($matchApi, ['RANKED_SOLO_5x5','RANKED_TEAM_3x3'], ['SEASON2015'],[1,2,3], 1);
        $this->assertEquals($expected, $result);
    }

}