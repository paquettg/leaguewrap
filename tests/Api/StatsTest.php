<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiStatsTest extends PHPUnit_Framework_TestCase {

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

	public function testSummary()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/stats/by-summoner/74602/summary', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"playerStatSummaries":[{"playerStatSummaryType":"AramUnranked5x5","wins":0,"modifyDate":1389321706000,"aggregatedStats":{"totalChampionKills":1,"totalTurretsKilled":0,"totalAssists":2}},{"playerStatSummaryType":"OdinUnranked","wins":1,"modifyDate":1335880273000,"aggregatedStats":{"totalChampionKills":22,"totalAssists":34,"maxChampionsKilled":9,"averageNodeCapture":5,"averageNodeNeutralize":3,"averageTeamObjective":1,"averageTotalPlayerScore":875,"averageCombatPlayerScore":305,"averageObjectivePlayerScore":570,"averageNodeCaptureAssist":1,"averageNodeNeutralizeAssist":1,"maxNodeCapture":9,"maxNodeNeutralize":7,"maxTeamObjective":1,"maxTotalPlayerScore":1508,"maxCombatPlayerScore":477,"maxObjectivePlayerScore":1031,"maxNodeCaptureAssist":2,"maxNodeNeutralizeAssist":1,"totalNodeNeutralize":14,"totalNodeCapture":19,"averageChampionsKilled":6,"averageNumDeaths":7,"averageAssists":9,"maxAssists":12}},{"playerStatSummaryType":"RankedPremade3x3","wins":0,"losses":0,"modifyDate":1347501723000,"aggregatedStats":{}},{"playerStatSummaryType":"RankedPremade5x5","wins":0,"losses":0,"modifyDate":1347501723000,"aggregatedStats":{}},{"playerStatSummaryType":"RankedSolo5x5","wins":27,"losses":30,"modifyDate":1389732101000,"aggregatedStats":{"totalChampionKills":67,"totalMinionKills":2396,"totalTurretsKilled":14,"totalNeutralMinionsKilled":86,"totalAssists":740}},{"playerStatSummaryType":"Unranked","wins":435,"modifyDate":1365061780000,"aggregatedStats":{"totalChampionKills":117,"totalMinionKills":3350,"totalTurretsKilled":26,"totalNeutralMinionsKilled":289,"totalAssists":442}},{"playerStatSummaryType":"Unranked3x3","wins":0,"modifyDate":1351133157000,"aggregatedStats":{}}]}');

		$api = new Api('key', $this->client);
		$stats = $api->stats()->summary(74602);
		$this->assertTrue($stats[0] instanceof LeagueWrap\Response\PlayerStats);
	}

	public function testSummarySummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/stats/by-summoner/74602/summary', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"playerStatSummaries":[{"playerStatSummaryType":"AramUnranked5x5","wins":0,"modifyDate":1389321706000,"aggregatedStats":{"totalChampionKills":1,"totalTurretsKilled":0,"totalAssists":2}},{"playerStatSummaryType":"OdinUnranked","wins":1,"modifyDate":1335880273000,"aggregatedStats":{"totalChampionKills":22,"totalAssists":34,"maxChampionsKilled":9,"averageNodeCapture":5,"averageNodeNeutralize":3,"averageTeamObjective":1,"averageTotalPlayerScore":875,"averageCombatPlayerScore":305,"averageObjectivePlayerScore":570,"averageNodeCaptureAssist":1,"averageNodeNeutralizeAssist":1,"maxNodeCapture":9,"maxNodeNeutralize":7,"maxTeamObjective":1,"maxTotalPlayerScore":1508,"maxCombatPlayerScore":477,"maxObjectivePlayerScore":1031,"maxNodeCaptureAssist":2,"maxNodeNeutralizeAssist":1,"totalNodeNeutralize":14,"totalNodeCapture":19,"averageChampionsKilled":6,"averageNumDeaths":7,"averageAssists":9,"maxAssists":12}},{"playerStatSummaryType":"RankedPremade3x3","wins":0,"losses":0,"modifyDate":1347501723000,"aggregatedStats":{}},{"playerStatSummaryType":"RankedPremade5x5","wins":0,"losses":0,"modifyDate":1347501723000,"aggregatedStats":{}},{"playerStatSummaryType":"RankedSolo5x5","wins":27,"losses":30,"modifyDate":1389732101000,"aggregatedStats":{"totalChampionKills":67,"totalMinionKills":2396,"totalTurretsKilled":14,"totalNeutralMinionsKilled":86,"totalAssists":740}},{"playerStatSummaryType":"Unranked","wins":435,"modifyDate":1365061780000,"aggregatedStats":{"totalChampionKills":117,"totalMinionKills":3350,"totalTurretsKilled":26,"totalNeutralMinionsKilled":289,"totalAssists":442}},{"playerStatSummaryType":"Unranked3x3","wins":0,"modifyDate":1351133157000,"aggregatedStats":{}}]}');
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"id":74602,"name":"bakasan","profileIconId":24,"summonerLevel":30,"revisionDate":1389732101000}');

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$api->stats()->summary($bakasan);
		$this->assertTrue($bakasan->stats[0] instanceof LeagueWrap\Response\PlayerStats);
	}

	public function testRanked()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/stats/by-summoner/74602/ranked', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn('{"summonerId":74602,"modifyDate":1389732101000,"champions":[{"id":53,"name":"Blitzcrank","stats":{"totalSessionsPlayed":3,"totalSessionsLost":0,"totalSessionsWon":3,"totalChampionKills":4,"totalDamageDealt":80620,"totalDamageTaken":75260,"mostChampionKillsPerSession":2,"totalMinionKills":55,"totalDoubleKills":0,"totalTripleKills":0,"totalQuadraKills":0,"totalPentaKills":0,"totalUnrealKills":0,"totalDeathsPerSession":13,"totalGoldEarned":34998,"mostSpellsCast":0,"totalTurretsKilled":0,"totalPhysicalDamageDealt":24853,"totalMagicDamageDealt":55765,"totalFirstBlood":0,"totalAssists":53,"maxChampionsKilled":2,"maxNumDeaths":6}},{"id":37,"name":"Sona","stats":{"totalSessionsPlayed":14,"totalSessionsLost":9,"totalSessionsWon":5,"totalChampionKills":16,"totalDamageDealt":344205,"totalDamageTaken":227998,"mostChampionKillsPerSession":3,"totalMinionKills":262,"totalDoubleKills":0,"totalTripleKills":0,"totalQuadraKills":0,"totalPentaKills":0,"totalUnrealKills":0,"totalDeathsPerSession":87,"totalGoldEarned":107046,"mostSpellsCast":0,"totalTurretsKilled":5,"totalPhysicalDamageDealt":63264,"totalMagicDamageDealt":280425,"totalFirstBlood":0,"totalAssists":186,"maxChampionsKilled":3,"maxNumDeaths":11}},{"id":86,"name":"Garen","stats":{"totalSessionsPlayed":2,"totalSessionsLost":1,"totalSessionsWon":1,"totalChampionKills":4,"totalDamageDealt":142051,"totalDamageTaken":57266,"mostChampionKillsPerSession":3,"totalMinionKills":182,"totalDoubleKills":0,"totalTripleKills":0,"totalQuadraKills":0,"totalPentaKills":0,"totalUnrealKills":0,"totalDeathsPerSession":11,"totalGoldEarned":19098,"mostSpellsCast":0,"totalTurretsKilled":0,"totalPhysicalDamageDealt":119907,"totalMagicDamageDealt":22144,"totalFirstBlood":0,"totalAssists":22,"maxChampionsKilled":3,"maxNumDeaths":8}},{"id":30,"name":"Karthus","stats":{"totalSessionsPlayed":5,"totalSessionsLost":3,"totalSessionsWon":2,"totalChampionKills":17,"totalDamageDealt":512956,"totalDamageTaken":116238,"mostChampionKillsPerSession":6,"totalMinionKills":709,"totalDoubleKills":0,"totalTripleKills":0,"totalQuadraKills":0,"totalPentaKills":0,"totalUnrealKills":0,"totalDeathsPerSession":43,"totalGoldEarned":51629,"mostSpellsCast":0,"totalTurretsKilled":0,"totalPhysicalDamageDealt":24058,"totalMagicDamageDealt":487005,"totalFirstBlood":0,"totalAssists":56,"maxChampionsKilled":6,"maxNumDeaths":14}},{"id":99,"name":"Lux","stats":{"totalSessionsPlayed":1,"totalSessionsLost":1,"totalSessionsWon":0,"totalChampionKills":0,"totalDamageDealt":21901,"totalDamageTaken":8875,"mostChampionKillsPerSession":0,"totalMinionKills":21,"totalDoubleKills":0,"totalTripleKills":0,"totalQuadraKills":0,"totalPentaKills":0,"totalUnrealKills":0,"totalDeathsPerSession":3,"totalGoldEarned":4214,"mostSpellsCast":0,"totalTurretsKilled":0,"totalPhysicalDamageDealt":3630,"totalMagicDamageDealt":18271,"totalFirstBlood":0,"totalAssists":3,"maxChampionsKilled":0,"maxNumDeaths":3}}]}');

		$api = new Api('key', $this->client);
		$stats = $api->stats()->ranked(74602);
		$this->assertTrue($stats[0] instanceof LeagueWrap\Response\Champion);
	}
}

