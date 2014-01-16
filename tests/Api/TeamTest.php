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
		             ->andReturn($this->response());

		$api   = new Api('key', $this->client);
		$teams = $api->team()->team(492066);
		$this->assertEquals('C9', $teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa']->tag);
	}

	public function testTeamSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($this->response());
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/by-name/C9 Hai', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":492066,"name":"C9 Hai","profileIconId":554,"summonerLevel":30,"revisionDate":1389835417000}');
		
		$api = new Api('key', $this->client);
		$hai = $api->summoner()->info('C9 Hai');
		$api->team()->team($hai);
		$this->assertTrue($hai->teams['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'] instanceof LeagueWrap\Response\Team);
	}

	public function testTeamSummonerMember()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.2/team/by-summoner/492066', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn($this->response());
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/by-name/C9 Hai', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":492066,"name":"C9 Hai","profileIconId":554,"summonerLevel":30,"revisionDate":1389835417000}');
		
		$api  = new Api('key', $this->client);
		$hai  = $api->summoner()->info('C9 Hai');
		$team = $api->team()->team($hai)['TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa'];
		$this->assertEquals('MEMBER', $team->roster->member(19302712)->status);
	}

	protected function response()
	{
		return '
		[ {
  	  	  "fullId" : "TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa",
  	  	  "name" : "Cloud 9 HyperX",
  	  	  "tag" : "C9",
  	  	  "status" : "RANKED",
  	  	  "teamStatSummary" : {
    		"fullId" : "TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa",
    		"teamStatDetails" : [ {
      	  	  "fullId" : "TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa",
      	  	  "teamStatType" : "RANKED_TEAM_5x5",
      	  	  "wins" : 33,
      	  	  "losses" : 3,
      	  	  "averageGamesPlayed" : 0
    		}, {
      	  	  "fullId" : "TEAM-9baaf74e-ea61-4ebc-82d9-b013d29399fa",
      	  	  "teamStatType" : "RANKED_TEAM_3x3",
      	  	  "wins" : 17,
      	  	  "losses" : 2,
      	  	  "averageGamesPlayed" : 0
    		} ]
  	  	  },
  	  	  "roster" : {
    		"ownerId" : 19302712,
    		"memberList" : [ {
      	  	  "playerId" : 19302712,
      	  	  "joinDate" : 1333694760000,
      	  	  "inviteDate" : 1333694400000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 492066,
      	  	  "joinDate" : 1352947432000,
      	  	  "inviteDate" : 1352947425000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 19238304,
      	  	  "joinDate" : 1359077785000,
      	  	  "inviteDate" : 1359077736000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 390600,
      	  	  "joinDate" : 1361502390000,
      	  	  "inviteDate" : 1361502386000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 51405,
      	  	  "joinDate" : 1365111646000,
      	  	  "inviteDate" : 1365111633000,
      	  	  "status" : "MEMBER"
    		} ]
  	  	  },
  	  	  "matchHistory" : [ {
    		"kills" : 27,
    		"deaths" : 30,
    		"opposingTeamKills" : 30,
    		"assists" : 57,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "New World Eclipse",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 890720251
  	  	  }, {
    		"kills" : 22,
    		"deaths" : 16,
    		"opposingTeamKills" : 16,
    		"assists" : 17,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "BigDikBanditz",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 855193201
  	  	  }, {
    		"kills" : 17,
    		"deaths" : 13,
    		"opposingTeamKills" : 13,
    		"assists" : 18,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "ROUND4",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 845183452
  	  	  }, {
    		"kills" : 13,
    		"deaths" : 8,
    		"opposingTeamKills" : 8,
    		"assists" : 6,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Chunkaroonies",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 845105488
  	  	  }, {
    		"kills" : 21,
    		"deaths" : 17,
    		"opposingTeamKills" : 17,
    		"assists" : 25,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "HIGH SKILL D1CKHEADS",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 845090565
  	  	  }, {
    		"kills" : 29,
    		"deaths" : 18,
    		"opposingTeamKills" : 17,
    		"assists" : 24,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "The Turkey Slap",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 845022085
  	  	  }, {
    		"kills" : 28,
    		"deaths" : 10,
    		"opposingTeamKills" : 10,
    		"assists" : 32,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "SupaSmashBros",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831676029
  	  	  }, {
    		"kills" : 18,
    		"deaths" : 15,
    		"opposingTeamKills" : 15,
    		"assists" : 26,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Connies Cadets",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831636239
  	  	  }, {
    		"kills" : 13,
    		"deaths" : 31,
    		"opposingTeamKills" : 31,
    		"assists" : 14,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "We Own This Map",
    		"win" : false,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831583513
  	  	  }, {
    		"kills" : 35,
    		"deaths" : 33,
    		"opposingTeamKills" : 33,
    		"assists" : 46,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "We Own This Map",
    		"win" : false,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831522129
  	  	  }, {
    		"kills" : 19,
    		"deaths" : 5,
    		"opposingTeamKills" : 4,
    		"assists" : 14,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "The Rotators",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831458771
  	  	  }, {
    		"kills" : 22,
    		"deaths" : 15,
    		"opposingTeamKills" : 15,
    		"assists" : 24,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "DESUUUUUUUUUUUUUUUUUUU",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831431214
  	  	  }, {
    		"kills" : 21,
    		"deaths" : 14,
    		"opposingTeamKills" : 14,
    		"assists" : 22,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "WhiperSnapers",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831383636
  	  	  }, {
    		"kills" : 14,
    		"deaths" : 9,
    		"opposingTeamKills" : 9,
    		"assists" : 5,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Furious Three",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 831337644
  	  	  }, {
    		"kills" : 15,
    		"deaths" : 6,
    		"opposingTeamKills" : 6,
    		"assists" : 9,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "ashe hole",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 827374789
  	  	  }, {
    		"kills" : 19,
    		"deaths" : 10,
    		"opposingTeamKills" : 10,
    		"assists" : 19,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "The Saga of Moon Moon",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 827339716
  	  	  }, {
    		"kills" : 22,
    		"deaths" : 9,
    		"opposingTeamKills" : 9,
    		"assists" : 30,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Off In The Forest",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 827252214
  	  	  }, {
    		"kills" : 12,
    		"deaths" : 7,
    		"opposingTeamKills" : 7,
    		"assists" : 7,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "6 Guys",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 827196504
  	  	  }, {
    		"kills" : 18,
    		"deaths" : 8,
    		"opposingTeamKills" : 6,
    		"assists" : 17,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Urf Freedom Force",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 827172044
  	  	  }, {
    		"kills" : 7,
    		"deaths" : 2,
    		"opposingTeamKills" : 2,
    		"assists" : 6,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "We Are Free Elo",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 827142660
  	  	  } ],
  	  	  "createDate" : 1333694386000,
  	  	  "modifyDate" : 1384544956000,
  	  	  "lastJoinDate" : 1365111646000,
  	  	  "secondLastJoinDate" : 1364435672000,
  	  	  "thirdLastJoinDate" : 1364435649000,
  	  	  "lastGameDate" : 1369871109000,
  	  	  "lastJoinedRankedTeamQueueDate" : 1387688785000
		}, {
  	  	  "fullId" : "TEAM-aabdb780-352c-11e3-963b-782bcb4d1861",
  	  	  "name" : "lastminutechallengerplsh",
  	  	  "tag" : "hotsho",
  	  	  "status" : "RANKED",
  	  	  "teamStatSummary" : {
    		"fullId" : "TEAM-aabdb780-352c-11e3-963b-782bcb4d1861",
    		"teamStatDetails" : [ {
      	  	  "fullId" : "TEAM-aabdb780-352c-11e3-963b-782bcb4d1861",
      	  	  "teamStatType" : "RANKED_TEAM_5x5",
      	  	  "wins" : 18,
      	  	  "losses" : 1,
      	  	  "averageGamesPlayed" : 0
    		}, {
      	  	  "fullId" : "TEAM-aabdb780-352c-11e3-963b-782bcb4d1861",
      	  	  "teamStatType" : "RANKED_TEAM_3x3",
      	  	  "wins" : 1,
      	  	  "losses" : 0,
      	  	  "averageGamesPlayed" : 0
    		} ]
  	  	  },
  	  	  "roster" : {
    		"ownerId" : 20132258,
    		"memberList" : [ {
      	  	  "playerId" : 21705406,
      	  	  "joinDate" : 1381795171000,
      	  	  "inviteDate" : 1381795171000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 19660288,
      	  	  "joinDate" : 1381795509000,
      	  	  "inviteDate" : 1381795198000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 2648,
      	  	  "joinDate" : 1381795209000,
      	  	  "inviteDate" : 1381795201000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 407750,
      	  	  "joinDate" : 1381795331000,
      	  	  "inviteDate" : 1381795317000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 20132258,
      	  	  "joinDate" : 1381795468000,
      	  	  "inviteDate" : 1381795461000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 442232,
      	  	  "joinDate" : 1383188471000,
      	  	  "inviteDate" : 1383188329000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 68232,
      	  	  "joinDate" : 1383188342000,
      	  	  "inviteDate" : 1383188337000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 21622356,
      	  	  "joinDate" : 1383188377000,
      	  	  "inviteDate" : 1383188370000,
      	  	  "status" : "MEMBER"
    		}, {
      	  	  "playerId" : 492066,
      	  	  "joinDate" : 1384140970000,
      	  	  "inviteDate" : 1384140922000,
      	  	  "status" : "MEMBER"
    		} ]
  	  	  },
  	  	  "matchHistory" : [ {
    		"kills" : 37,
    		"deaths" : 29,
    		"opposingTeamKills" : 29,
    		"assists" : 53,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "UA eLEMONators",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1153828643
  	  	  }, {
    		"kills" : 26,
    		"deaths" : 13,
    		"opposingTeamKills" : 13,
    		"assists" : 38,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Team Luck Sacks",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1153804010
  	  	  }, {
    		"kills" : 29,
    		"deaths" : 18,
    		"opposingTeamKills" : 18,
    		"assists" : 55,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Team Luck Sacks",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1153772808
  	  	  }, {
    		"kills" : 24,
    		"deaths" : 13,
    		"opposingTeamKills" : 13,
    		"assists" : 28,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Team Gweedo Puns",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1153737703
  	  	  }, {
    		"kills" : 58,
    		"deaths" : 28,
    		"opposingTeamKills" : 28,
    		"assists" : 62,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Équipe Marois",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1153673976
  	  	  }, {
    		"kills" : 29,
    		"deaths" : 16,
    		"opposingTeamKills" : 14,
    		"assists" : 36,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Slof Army",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1153629699
  	  	  }, {
    		"kills" : 26,
    		"deaths" : 27,
    		"opposingTeamKills" : 26,
    		"assists" : 39,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Wizzy and the Bois",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1151746208
  	  	  }, {
    		"kills" : 9,
    		"deaths" : 23,
    		"opposingTeamKills" : 23,
    		"assists" : 9,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "YetiBotPractices",
    		"win" : false,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1151461324
  	  	  }, {
    		"kills" : 25,
    		"deaths" : 10,
    		"opposingTeamKills" : 10,
    		"assists" : 27,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "TWERKitandJERKit",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 10,
    		"gameId" : 1143524039
  	  	  }, {
    		"kills" : 17,
    		"deaths" : 23,
    		"opposingTeamKills" : 22,
    		"assists" : 27,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Pink Pwnys",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1139065851
  	  	  }, {
    		"kills" : 35,
    		"deaths" : 10,
    		"opposingTeamKills" : 10,
    		"assists" : 29,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "How Tooo play",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1139035040
  	  	  }, {
    		"kills" : 33,
    		"deaths" : 9,
    		"opposingTeamKills" : 7,
    		"assists" : 51,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "ballsack around ur anus",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1139020138
  	  	  }, {
    		"kills" : 33,
    		"deaths" : 27,
    		"opposingTeamKills" : 27,
    		"assists" : 65,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "I Want Zyra",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1138972053
  	  	  }, {
    		"kills" : 36,
    		"deaths" : 13,
    		"opposingTeamKills" : 13,
    		"assists" : 47,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "aKa InsighT 2",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1138941750
  	  	  }, {
    		"kills" : 30,
    		"deaths" : 18,
    		"opposingTeamKills" : 18,
    		"assists" : 42,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "6th Floor",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1119532813
  	  	  }, {
    		"kills" : 38,
    		"deaths" : 25,
    		"opposingTeamKills" : 23,
    		"assists" : 59,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Outlast your Dog",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1119485592
  	  	  }, {
    		"kills" : 34,
    		"deaths" : 17,
    		"opposingTeamKills" : 17,
    		"assists" : 42,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Outlast your Dog",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1119448411
  	  	  }, {
    		"kills" : 29,
    		"deaths" : 27,
    		"opposingTeamKills" : 27,
    		"assists" : 44,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "KJLDLJDLDJ",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1119395905
  	  	  }, {
    		"kills" : 30,
    		"deaths" : 16,
    		"opposingTeamKills" : 16,
    		"assists" : 38,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Anola and the Dorans",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1119365245
  	  	  }, {
    		"kills" : 38,
    		"deaths" : 31,
    		"opposingTeamKills" : 31,
    		"assists" : 55,
    		"gameMode" : "CLASSIC",
    		"opposingTeamName" : "Team Bison",
    		"win" : true,
    		"invalid" : false,
    		"mapId" : 1,
    		"gameId" : 1119317810
  	  	  } ],
  	  	  "createDate" : 1381795171000,
  	  	  "modifyDate" : 1384155529000,
  	  	  "lastJoinDate" : 1384140970000,
  	  	  "secondLastJoinDate" : 1383188471000,
  	  	  "thirdLastJoinDate" : 1383188377000,
  	  	  "lastGameDate" : 1384155529000,
  	  	  "lastJoinedRankedTeamQueueDate" : 1384153062000
		} ]';
	}
}
