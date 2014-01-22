<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiLeagueTest extends PHPUnit_Framework_TestCase {

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

	public function testLeague()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/league/by-summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($this->league());

		$api = new Api('key', $this->client);
		$leagues = $api->league()->league(74602);
		$this->assertTrue($leagues[74602] instanceof LeagueWrap\Response\League);
	}

	public function testLeagueSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/league/by-summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($this->league());
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"bakasan":{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$api->league()->league($bakasan);
		$this->assertTrue($bakasan->league('bakasan') instanceof LeagueWrap\Response\League);
	}

	public function testLeagueSummonerEntry()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/league/by-summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($this->league());
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"bakasan":{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$api->league()->league($bakasan);
		$first = $bakasan->league('bakasan')->entry(39233327);
		$this->assertEquals('omg taters', $first->playerOrTeamName);
	}

	public function testLeagueSummonerPlayerOrTeam()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/league/by-summoner/74602', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($this->league());
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"bakasan":{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$api->league()->league($bakasan);
		$myTeam = $bakasan->league('bakasan')->playerOrTeam;
		$this->assertEquals(2, $myTeam->miniSeries->target);
	}
	protected function league()
	{
		return '
{
  "74602" : {
    "name" : "Akali\'s Rogues",
    "tier" : "SILVER",
    "queue" : "RANKED_SOLO_5x5",
    "entries" : [ {
      "playerOrTeamId" : "39233327",
      "playerOrTeamName" : "omg taters",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 24,
      "wins" : 8,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19458411",
      "playerOrTeamName" : "Acesx",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 74,
      "wins" : 430,
      "isHotStreak" : true,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "25183744",
      "playerOrTeamName" : "Rugiewit",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 53,
      "wins" : 51,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19563384",
      "playerOrTeamName" : "Renavi",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 0,
      "wins" : 103,
      "isHotStreak" : true,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19502483",
      "playerOrTeamName" : "MidEastBeast59",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 55,
      "wins" : 87,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "23329709",
      "playerOrTeamName" : "Loli Rei Inari",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 80,
      "wins" : 70,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "23344544",
      "playerOrTeamName" : "Imposter Cure",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 11,
      "wins" : 419,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "21444001",
      "playerOrTeamName" : "Mnemos",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 100,
      "wins" : 8,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0,
      "miniSeries" : {
        "target" : 2,
        "wins" : 0,
        "losses" : 0,
        "timeLeftToPlayMillis" : 0,
        "progress" : "NNN"
      }
    }, {
      "playerOrTeamId" : "20551634",
      "playerOrTeamName" : "BeastOG",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 53,
      "wins" : 400,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "24265931",
      "playerOrTeamName" : "Und34d Stalker",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 34,
      "wins" : 541,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "25393406",
      "playerOrTeamName" : "rarekiller",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 6,
      "wins" : 95,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "21270346",
      "playerOrTeamName" : "Ferakash",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 52,
      "wins" : 330,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "22526886",
      "playerOrTeamName" : "Ez0 xxanders",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 19,
      "wins" : 214,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20478160",
      "playerOrTeamName" : "Dont ask Apple",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 58,
      "wins" : 26,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20983075",
      "playerOrTeamName" : "Aderen",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 8,
      "wins" : 54,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19362009",
      "playerOrTeamName" : "xXCFXx Fenrir",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 66,
      "wins" : 123,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20037352",
      "playerOrTeamName" : "1Frame",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 2,
      "wins" : 119,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20171131",
      "playerOrTeamName" : "El Tigre Fuego",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 76,
      "wins" : 264,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "38795341",
      "playerOrTeamName" : "A Wild Reapzter",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 91,
      "wins" : 33,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "23124439",
      "playerOrTeamName" : "CKWIC",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 36,
      "wins" : 11,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "33117",
      "playerOrTeamName" : "Omegareaven",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 100,
      "wins" : 9,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0,
      "miniSeries" : {
        "target" : 2,
        "wins" : 0,
        "losses" : 0,
        "timeLeftToPlayMillis" : 0,
        "progress" : "NNN"
      }
    }, {
      "playerOrTeamId" : "22627309",
      "playerOrTeamName" : "PyloNazTLO",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 53,
      "wins" : 292,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19996287",
      "playerOrTeamName" : "BubbIs",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 64,
      "wins" : 45,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20653888",
      "playerOrTeamName" : "Derk Smite",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 100,
      "wins" : 119,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0,
      "miniSeries" : {
        "target" : 2,
        "wins" : 0,
        "losses" : 0,
        "timeLeftToPlayMillis" : 0,
        "progress" : "NNN"
      }
    }, {
      "playerOrTeamId" : "29272711",
      "playerOrTeamName" : "Ookamikaji",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 17,
      "wins" : 35,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19825200",
      "playerOrTeamName" : "Mr Lolsucks",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 76,
      "wins" : 41,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "23462711",
      "playerOrTeamName" : "gamerenemy",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 36,
      "wins" : 310,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "24020617",
      "playerOrTeamName" : "Strawberry Eater",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 100,
      "wins" : 71,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0,
      "miniSeries" : {
        "target" : 2,
        "wins" : 0,
        "losses" : 0,
        "timeLeftToPlayMillis" : 0,
        "progress" : "NNN"
      }
    }, {
      "playerOrTeamId" : "21750904",
      "playerOrTeamName" : "Eragon20",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 72,
      "wins" : 411,
      "isHotStreak" : true,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19783075",
      "playerOrTeamName" : "Gym",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 7,
      "wins" : 393,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19918655",
      "playerOrTeamName" : "JesusRice",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 21,
      "wins" : 94,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "30358407",
      "playerOrTeamName" : "Gay for Krepo",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 0,
      "wins" : 103,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "21779200",
      "playerOrTeamName" : "Killacam23424",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 0,
      "wins" : 245,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19359200",
      "playerOrTeamName" : "Turtle919",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 65,
      "wins" : 56,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "24154501",
      "playerOrTeamName" : "LgndaryWarrior",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 75,
      "wins" : 231,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "21959196",
      "playerOrTeamName" : "Pyraclasmic",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 84,
      "wins" : 37,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "349092",
      "playerOrTeamName" : "Micdog",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 82,
      "wins" : 113,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19460879",
      "playerOrTeamName" : "asian1ninja",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 51,
      "wins" : 486,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19018373",
      "playerOrTeamName" : "Sentory",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 59,
      "wins" : 12,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20743532",
      "playerOrTeamName" : "bakardi",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 58,
      "wins" : 60,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19188726",
      "playerOrTeamName" : "Khaos9836",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 64,
      "wins" : 268,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "37306284",
      "playerOrTeamName" : "FiFL Nova",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 5,
      "wins" : 51,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "34943000",
      "playerOrTeamName" : "DericDraco35",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 14,
      "wins" : 39,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19913580",
      "playerOrTeamName" : "Eseerrow EZ",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 10,
      "wins" : 10,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "23563154",
      "playerOrTeamName" : "Chärizard",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 11,
      "wins" : 192,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20977502",
      "playerOrTeamName" : "LawstCawz",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 83,
      "wins" : 57,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0,
      "miniSeries" : {
        "target" : 2,
        "wins" : 0,
        "losses" : 1,
        "timeLeftToPlayMillis" : 0,
        "progress" : "LNN"
      }
    }, {
      "playerOrTeamId" : "21513200",
      "playerOrTeamName" : "Roadkills",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 58,
      "wins" : 311,
      "isHotStreak" : true,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "44673276",
      "playerOrTeamName" : "pooniepoon",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 97,
      "wins" : 11,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19219587",
      "playerOrTeamName" : "xX Chi Dragon Xx",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 69,
      "wins" : 1105,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19647107",
      "playerOrTeamName" : "Magnus Mediere",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 8,
      "wins" : 189,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19896794",
      "playerOrTeamName" : "FoulBlade",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 28,
      "wins" : 331,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19455966",
      "playerOrTeamName" : "Bzariko",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 46,
      "wins" : 148,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "30821284",
      "playerOrTeamName" : "DarkPlated",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 0,
      "wins" : 137,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19455547",
      "playerOrTeamName" : "pennington1992",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 27,
      "wins" : 136,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19464510",
      "playerOrTeamName" : "my daddy luvs me",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 2,
      "wins" : 647,
      "isHotStreak" : true,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20750877",
      "playerOrTeamName" : "muzdog jr",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 73,
      "wins" : 34,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "45642146",
      "playerOrTeamName" : "Retro Zombie",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 0,
      "wins" : 14,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "22762693",
      "playerOrTeamName" : "Kemba Walker",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 0,
      "wins" : 5,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20148155",
      "playerOrTeamName" : "namildalol",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 56,
      "wins" : 171,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19208400",
      "playerOrTeamName" : "eXponent",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 0,
      "wins" : 189,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "27739470",
      "playerOrTeamName" : "DetectiveFinly",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 63,
      "wins" : 204,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "39983153",
      "playerOrTeamName" : "StarEcho",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 0,
      "wins" : 109,
      "isHotStreak" : true,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "22823512",
      "playerOrTeamName" : "pope alope",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 5,
      "wins" : 86,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20910793",
      "playerOrTeamName" : "Predatron",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 12,
      "wins" : 36,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19179424",
      "playerOrTeamName" : "xdarkfluxx",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 76,
      "wins" : 192,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "31991747",
      "playerOrTeamName" : "YTHT",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 75,
      "wins" : 103,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19455091",
      "playerOrTeamName" : "CHICKEN YEAH",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 36,
      "wins" : 218,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19145210",
      "playerOrTeamName" : "Aeoscar",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 59,
      "wins" : 431,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20979958",
      "playerOrTeamName" : "EZ joshto90",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 0,
      "wins" : 359,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "24301214",
      "playerOrTeamName" : "shatterEFFEX",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 75,
      "wins" : 68,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "21930476",
      "playerOrTeamName" : "InsaneSp00n",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 85,
      "wins" : 42,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0,
      "miniSeries" : {
        "target" : 3,
        "wins" : 0,
        "losses" : 1,
        "timeLeftToPlayMillis" : 0,
        "progress" : "LNNNN"
      }
    }, {
      "playerOrTeamId" : "144674",
      "playerOrTeamName" : "Tasdra",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 0,
      "wins" : 724,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "38973474",
      "playerOrTeamName" : "kiuoty",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "III",
      "leaguePoints" : 40,
      "wins" : 31,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "22935053",
      "playerOrTeamName" : "Blakeioh",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 95,
      "wins" : 222,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19458796",
      "playerOrTeamName" : "philippinocraka",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 13,
      "wins" : 136,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "18143",
      "playerOrTeamName" : "drakk",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 68,
      "wins" : 20,
      "isHotStreak" : true,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "31645452",
      "playerOrTeamName" : "C 4",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 70,
      "wins" : 88,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "28466828",
      "playerOrTeamName" : "Bhenoix",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 60,
      "wins" : 479,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "143628",
      "playerOrTeamName" : "DaemonLord",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 39,
      "wins" : 59,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "29343169",
      "playerOrTeamName" : "mynameisrawR",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 100,
      "wins" : 65,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0,
      "miniSeries" : {
        "target" : 2,
        "wins" : 0,
        "losses" : 0,
        "timeLeftToPlayMillis" : 0,
        "progress" : "NNN"
      }
    }, {
      "playerOrTeamId" : "19799740",
      "playerOrTeamName" : "Basc Vigil",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 59,
      "wins" : 126,
      "isHotStreak" : true,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19075899",
      "playerOrTeamName" : "Caedan",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 0,
      "wins" : 104,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "23790312",
      "playerOrTeamName" : "KAMCM",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 41,
      "wins" : 47,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "24016967",
      "playerOrTeamName" : "xTayumi",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "IV",
      "leaguePoints" : 21,
      "wins" : 603,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "47165089",
      "playerOrTeamName" : "AmigoHan",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 21,
      "wins" : 10,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "74602",
      "playerOrTeamName" : "bakasan",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 91,
      "wins" : 27,
      "isHotStreak" : false,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 1389760901178,
      "miniSeries" : {
        "target" : 2,
        "wins" : 0,
        "losses" : 1,
        "timeLeftToPlayMillis" : 2357678884,
        "progress" : "LNN"
      }
    }, {
      "playerOrTeamId" : "19484251",
      "playerOrTeamName" : "Kick Ass Joe",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 92,
      "wins" : 102,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19509172",
      "playerOrTeamName" : "SuperBTown",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 79,
      "wins" : 57,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "21861109",
      "playerOrTeamName" : "Ez0 Soldrin",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "V",
      "leaguePoints" : 91,
      "wins" : 20,
      "isHotStreak" : true,
      "isVeteran" : false,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20910756",
      "playerOrTeamName" : "0sirusD3m0n",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 34,
      "wins" : 260,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "20126085",
      "playerOrTeamName" : "Ognirr",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "I",
      "leaguePoints" : 76,
      "wins" : 150,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    }, {
      "playerOrTeamId" : "19461191",
      "playerOrTeamName" : "Mofiki",
      "leagueName" : "Akali\'s Rogues",
      "queueType" : "RANKED_SOLO_5x5",
      "tier" : "SILVER",
      "rank" : "II",
      "leaguePoints" : 23,
      "wins" : 325,
      "isHotStreak" : false,
      "isVeteran" : true,
      "isFreshBlood" : false,
      "isInactive" : false,
      "lastPlayed" : 0
    } ]
  }
}';
	}
}
