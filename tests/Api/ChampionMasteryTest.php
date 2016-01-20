<?php

use LeagueWrap\Api;
use Mockery as m;

class ChampionMasteryTest extends PHPUnit_Framework_TestCase
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

    public function testChampions() {
        $this->client->shouldReceive('baseUrl')->once();
        $this->client->shouldReceive('request')
            ->with('championmastery/location/EUW1/player/30447079/champions', [
                'api_key' => 'key'
            ])->once()
            ->andReturn(file_get_contents('tests/Json/championmastery.30447079.json'));

        $api = new Api('key', $this->client);
        $api->setRegion('euw');

        $championMasteries = $api->championMastery()->champions(30447079);
        $this->assertTrue($championMasteries instanceof \LeagueWrap\Dto\ChampionMasteryList);
    }

    public function testChampionId() {
        $this->client->shouldReceive('baseUrl')->once();
        $this->client->shouldReceive('request')
            ->with('championmastery/location/EUW1/player/30447079/champion/1', [
                'api_key' => 'key'
            ])->once()
            ->andReturn(file_get_contents('tests/Json/championmastery.30447079.1.json'));

        $api = new Api('key', $this->client);
        $api->setRegion('euw');

        $championMastery = $api->championMastery()->champion(30447079, 1);
        $this->assertTrue($championMastery instanceof \LeagueWrap\Dto\ChampionMastery);

    }

    public function testTopChampions() {
        $this->client->shouldReceive('baseUrl')->once();
        $this->client->shouldReceive('request')
            ->with('championmastery/location/EUW1/player/30447079/topchampions', [
                'api_key' => 'key',
                'count' => 3
            ])->once()
            ->andReturn(file_get_contents('tests/Json/championmastery.30447079.topcount3.json'));

        $api = new Api('key', $this->client);
        $api->setRegion('euw');

        $championMastery = $api->championMastery()->topChampions(30447079);
        $this->assertTrue($championMastery instanceof \LeagueWrap\Dto\ChampionMasteryList);
    }

    public function testTopChampionsWithCount() {
        $this->client->shouldReceive('baseUrl')->once();
        $this->client->shouldReceive('request')
            ->with('championmastery/location/EUW1/player/30447079/topchampions', [
                'api_key' => 'key',
                'count' => 1
            ])->once()
            ->andReturn(file_get_contents('tests/Json/championmastery.30447079.topcount3.json'));

        $api = new Api('key', $this->client);
        $api->setRegion('euw');

        $championMastery = $api->championMastery()->topChampions(30447079, 1);
        $this->assertTrue($championMastery instanceof \LeagueWrap\Dto\ChampionMasteryList);
    }

    public function testScore() {
        $this->client->shouldReceive('baseUrl')->once();
        $this->client->shouldReceive('request')
            ->with('championmastery/location/EUW1/player/30447079/score', [
                'api_key' => 'key'
            ])->once()
            ->andReturn(100);

        $api = new Api('key', $this->client);
        $api->setRegion('euw');

        $score = $api->championMastery()->score(30447079);
        $this->assertTrue($score == 100);
    }


    public function testScoreAttachResponse() {
        $this->client->shouldReceive('baseUrl')
            ->twice();
        $this->client->shouldReceive('request')
            ->with('championmastery/location/NA1/player/74602/score', [
                'api_key' => 'key'
            ])->once()
            ->andReturn(999);
        $this->client->shouldReceive('request')
            ->with('na/v1.4/summoner/by-name/bakasan', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api     = new Api('key', $this->client);
        $bakasan = $api->summoner()->info('bakasan');
        $api->championMastery()->score($bakasan);
        $this->assertTrue($bakasan->score == 999);
    }

        public function testChampionsAttachResponse() {
        $this->client->shouldReceive('baseUrl')
            ->twice();
        $this->client->shouldReceive('request')
            ->with('championmastery/location/NA1/player/74602/champions', [
                'api_key' => 'key'
            ])->once()
            ->andReturn(file_get_contents('tests/Json/championmastery.30447079.topcount3.json'));
        $this->client->shouldReceive('request')
            ->with('na/v1.4/summoner/by-name/bakasan', [
                'api_key' => 'key',
            ])->once()
            ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

        $api     = new Api('key', $this->client);
        $bakasan = $api->summoner()->info('bakasan');
        $api->championMastery()->champions($bakasan);
        $this->assertTrue($bakasan->championmastery instanceof \LeagueWrap\Dto\ChampionMasteryList);
    }

}