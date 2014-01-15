<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiGameTest extends PHPUnit_Framework_TestCase {

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

	public function testRecent()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"games":[{"gameId":1236563697,"invalid":false,"gameMode":"CLASSIC","gameType":"MATCHED_GAME","subType":"RANKED_SOLO_5x5","mapId":1,"teamId":200,"championId":44,"spell1":4,"spell2":3,"level":30,"createDate":1389760900588,"fellowPlayers":[{"summonerId":24119921,"teamId":200,"championId":222},{"summonerId":38591757,"teamId":100,"championId":75},{"summonerId":38111259,"teamId":100,"championId":98},{"summonerId":38831582,"teamId":100,"championId":51},{"summonerId":22973314,"teamId":200,"championId":102},{"summonerId":33369079,"teamId":200,"championId":10},{"summonerId":48181445,"teamId":100,"championId":16},{"summonerId":29352863,"teamId":200,"championId":19},{"summonerId":44675734,"teamId":100,"championId":79}],"stats":{"level":13,"goldEarned":8163,"numDeaths":5,"minionsKilled":20,"goldSpent":6940,"totalDamageDealt":11510,"totalDamageTaken":31660,"team":200,"win":false,"physicalDamageDealtPlayer":3617,"magicDamageDealtPlayer":5785,"physicalDamageTaken":13598,"magicDamageTaken":17278,"timePlayed":2065,"totalHeal":17336,"totalUnitsHealed":5,"assists":15,"item0":3401,"item1":2045,"item2":3117,"item3":3024,"item4":3105,"item6":3351,"sightWardsBought":1,"magicDamageDealtToChampions":3183,"physicalDamageDealtToChampions":293,"totalDamageDealtToChampions":3476,"trueDamageDealtPlayer":2107,"trueDamageTaken":784,"wardKilled":1,"wardPlaced":22,"totalTimeCrowdControlDealt":38},"createDateAsDate":"01/15/2014 04:41 AM UTC"},{"gameId":1236309934,"invalid":false,"gameMode":"CLASSIC","gameType":"MATCHED_GAME","subType":"RANKED_SOLO_5x5","mapId":1,"teamId":200,"championId":53,"spell1":4,"spell2":3,"level":30,"createDate":1389748252865,"fellowPlayers":[{"summonerId":43702263,"teamId":200,"championId":11},{"summonerId":37073302,"teamId":100,"championId":36},{"summonerId":25359525,"teamId":100,"championId":96},{"summonerId":21281323,"teamId":200,"championId":222},{"summonerId":34604751,"teamId":100,"championId":50},{"summonerId":44544410,"teamId":200,"championId":266},{"summonerId":30719900,"teamId":100,"championId":76},{"summonerId":42839206,"teamId":100,"championId":157},{"summonerId":21063490,"teamId":200,"championId":103}],"stats":{"level":18,"goldEarned":17421,"numDeaths":6,"minionsKilled":34,"championsKilled":2,"goldSpent":11025,"totalDamageDealt":48713,"totalDamageTaken":41697,"team":200,"win":true,"largestMultiKill":1,"physicalDamageDealtPlayer":13530,"magicDamageDealtPlayer":35183,"physicalDamageTaken":13208,"magicDamageTaken":25583,"timePlayed":3049,"totalHeal":40,"totalUnitsHealed":1,"assists":27,"item0":3069,"item1":2045,"item2":3190,"item3":3025,"item4":3274,"item5":3004,"item6":3364,"sightWardsBought":1,"magicDamageDealtToChampions":12123,"physicalDamageDealtToChampions":5953,"totalDamageDealtToChampions":18077,"trueDamageTaken":2905,"wardKilled":4,"wardPlaced":31,"totalTimeCrowdControlDealt":196},"createDateAsDate":"01/15/2014 01:10 AM UTC"}]}');

		$api   = new Api('key', $this->client);
		$games = $api->game()->recent(74602);
		$this->assertTrue($games[0] instanceof LeagueWrap\Response\Game);
	}

	public function testRecentSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"games":[{"gameId":1236563697,"invalid":false,"gameMode":"CLASSIC","gameType":"MATCHED_GAME","subType":"RANKED_SOLO_5x5","mapId":1,"teamId":200,"championId":44,"spell1":4,"spell2":3,"level":30,"createDate":1389760900588,"fellowPlayers":[{"summonerId":24119921,"teamId":200,"championId":222},{"summonerId":38591757,"teamId":100,"championId":75},{"summonerId":38111259,"teamId":100,"championId":98},{"summonerId":38831582,"teamId":100,"championId":51},{"summonerId":22973314,"teamId":200,"championId":102},{"summonerId":33369079,"teamId":200,"championId":10},{"summonerId":48181445,"teamId":100,"championId":16},{"summonerId":29352863,"teamId":200,"championId":19},{"summonerId":44675734,"teamId":100,"championId":79}],"stats":{"level":13,"goldEarned":8163,"numDeaths":5,"minionsKilled":20,"goldSpent":6940,"totalDamageDealt":11510,"totalDamageTaken":31660,"team":200,"win":false,"physicalDamageDealtPlayer":3617,"magicDamageDealtPlayer":5785,"physicalDamageTaken":13598,"magicDamageTaken":17278,"timePlayed":2065,"totalHeal":17336,"totalUnitsHealed":5,"assists":15,"item0":3401,"item1":2045,"item2":3117,"item3":3024,"item4":3105,"item6":3351,"sightWardsBought":1,"magicDamageDealtToChampions":3183,"physicalDamageDealtToChampions":293,"totalDamageDealtToChampions":3476,"trueDamageDealtPlayer":2107,"trueDamageTaken":784,"wardKilled":1,"wardPlaced":22,"totalTimeCrowdControlDealt":38},"createDateAsDate":"01/15/2014 04:41 AM UTC"},{"gameId":1236309934,"invalid":false,"gameMode":"CLASSIC","gameType":"MATCHED_GAME","subType":"RANKED_SOLO_5x5","mapId":1,"teamId":200,"championId":53,"spell1":4,"spell2":3,"level":30,"createDate":1389748252865,"fellowPlayers":[{"summonerId":43702263,"teamId":200,"championId":11},{"summonerId":37073302,"teamId":100,"championId":36},{"summonerId":25359525,"teamId":100,"championId":96},{"summonerId":21281323,"teamId":200,"championId":222},{"summonerId":34604751,"teamId":100,"championId":50},{"summonerId":44544410,"teamId":200,"championId":266},{"summonerId":30719900,"teamId":100,"championId":76},{"summonerId":42839206,"teamId":100,"championId":157},{"summonerId":21063490,"teamId":200,"championId":103}],"stats":{"level":18,"goldEarned":17421,"numDeaths":6,"minionsKilled":34,"championsKilled":2,"goldSpent":11025,"totalDamageDealt":48713,"totalDamageTaken":41697,"team":200,"win":true,"largestMultiKill":1,"physicalDamageDealtPlayer":13530,"magicDamageDealtPlayer":35183,"physicalDamageTaken":13208,"magicDamageTaken":25583,"timePlayed":3049,"totalHeal":40,"totalUnitsHealed":1,"assists":27,"item0":3069,"item1":2045,"item2":3190,"item3":3025,"item4":3274,"item5":3004,"item6":3364,"sightWardsBought":1,"magicDamageDealtToChampions":12123,"physicalDamageDealtToChampions":5953,"totalDamageDealtToChampions":18077,"trueDamageTaken":2905,"wardKilled":4,"wardPlaced":31,"totalTimeCrowdControlDealt":196},"createDateAsDate":"01/15/2014 01:10 AM UTC"}]}');
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');

		$api     = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$games   = $api->game()->recent($bakasan);
		$this->assertTrue($bakasan->recentGame(0) instanceof LeagueWrap\Response\Game);
	}

	public function testRecentStatsSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/game/by-summoner/74602/recent', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"games":[{"gameId":1236563697,"invalid":false,"gameMode":"CLASSIC","gameType":"MATCHED_GAME","subType":"RANKED_SOLO_5x5","mapId":1,"teamId":200,"championId":44,"spell1":4,"spell2":3,"level":30,"createDate":1389760900588,"fellowPlayers":[{"summonerId":24119921,"teamId":200,"championId":222},{"summonerId":38591757,"teamId":100,"championId":75},{"summonerId":38111259,"teamId":100,"championId":98},{"summonerId":38831582,"teamId":100,"championId":51},{"summonerId":22973314,"teamId":200,"championId":102},{"summonerId":33369079,"teamId":200,"championId":10},{"summonerId":48181445,"teamId":100,"championId":16},{"summonerId":29352863,"teamId":200,"championId":19},{"summonerId":44675734,"teamId":100,"championId":79}],"stats":{"level":13,"goldEarned":8163,"numDeaths":5,"minionsKilled":20,"goldSpent":6940,"totalDamageDealt":11510,"totalDamageTaken":31660,"team":200,"win":false,"physicalDamageDealtPlayer":3617,"magicDamageDealtPlayer":5785,"physicalDamageTaken":13598,"magicDamageTaken":17278,"timePlayed":2065,"totalHeal":17336,"totalUnitsHealed":5,"assists":15,"item0":3401,"item1":2045,"item2":3117,"item3":3024,"item4":3105,"item6":3351,"sightWardsBought":1,"magicDamageDealtToChampions":3183,"physicalDamageDealtToChampions":293,"totalDamageDealtToChampions":3476,"trueDamageDealtPlayer":2107,"trueDamageTaken":784,"wardKilled":1,"wardPlaced":22,"totalTimeCrowdControlDealt":38},"createDateAsDate":"01/15/2014 04:41 AM UTC"},{"gameId":1236309934,"invalid":false,"gameMode":"CLASSIC","gameType":"MATCHED_GAME","subType":"RANKED_SOLO_5x5","mapId":1,"teamId":200,"championId":53,"spell1":4,"spell2":3,"level":30,"createDate":1389748252865,"fellowPlayers":[{"summonerId":43702263,"teamId":200,"championId":11},{"summonerId":37073302,"teamId":100,"championId":36},{"summonerId":25359525,"teamId":100,"championId":96},{"summonerId":21281323,"teamId":200,"championId":222},{"summonerId":34604751,"teamId":100,"championId":50},{"summonerId":44544410,"teamId":200,"championId":266},{"summonerId":30719900,"teamId":100,"championId":76},{"summonerId":42839206,"teamId":100,"championId":157},{"summonerId":21063490,"teamId":200,"championId":103}],"stats":{"level":18,"goldEarned":17421,"numDeaths":6,"minionsKilled":34,"championsKilled":2,"goldSpent":11025,"totalDamageDealt":48713,"totalDamageTaken":41697,"team":200,"win":true,"largestMultiKill":1,"physicalDamageDealtPlayer":13530,"magicDamageDealtPlayer":35183,"physicalDamageTaken":13208,"magicDamageTaken":25583,"timePlayed":3049,"totalHeal":40,"totalUnitsHealed":1,"assists":27,"item0":3069,"item1":2045,"item2":3190,"item3":3025,"item4":3274,"item5":3004,"item6":3364,"sightWardsBought":1,"magicDamageDealtToChampions":12123,"physicalDamageDealtToChampions":5953,"totalDamageDealtToChampions":18077,"trueDamageTaken":2905,"wardKilled":4,"wardPlaced":31,"totalTimeCrowdControlDealt":196},"createDateAsDate":"01/15/2014 01:10 AM UTC"}]}');
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');

		$api     = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$games   = $api->game()->recent($bakasan);
		$game    = $bakasan->recentGame(0);
		$this->assertEquals(13, $game->stats->level);
	}
}

