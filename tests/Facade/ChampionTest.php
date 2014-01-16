<?php

use Mockery as m;

class FacadeChampionTest extends PHPUnit_Framework_TestCase {

	protected $client;

	public function setUp()
	{
		$this->client = m::mock('LeagueWrap\Client');
		LeagueWrap\StaticApi::mount();
	}

	public function tearDown()
	{
		m::close();
	}

	public function testInfo()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.1/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn('{"champions":[{"id":266,"name":"Aatrox","active":true,"attackRank":8,"defenseRank":4,"magicRank":3,"difficultyRank":6,"botEnabled":false,"freeToPlay":false,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":103,"name":"Ahri","active":true,"attackRank":3,"defenseRank":4,"magicRank":8,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":84,"name":"Akali","active":true,"attackRank":5,"defenseRank":3,"magicRank":8,"difficultyRank":6,"botEnabled":false,"freeToPlay":false,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":12,"name":"Alistar","active":true,"attackRank":6,"defenseRank":9,"magicRank":5,"difficultyRank":8,"botEnabled":false,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":32,"name":"Amumu","active":true,"attackRank":2,"defenseRank":6,"magicRank":8,"difficultyRank":4,"botEnabled":false,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":34,"name":"Anivia","active":true,"attackRank":1,"defenseRank":4,"magicRank":10,"difficultyRank":8,"botEnabled":false,"freeToPlay":false,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":1,"name":"Annie","active":true,"attackRank":2,"defenseRank":3,"magicRank":10,"difficultyRank":4,"botEnabled":true,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":22,"name":"Ashe","active":true,"attackRank":7,"defenseRank":3,"magicRank":2,"difficultyRank":4,"botEnabled":true,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":53,"name":"Blitzcrank","active":true,"attackRank":4,"defenseRank":8,"magicRank":5,"difficultyRank":6,"botEnabled":false,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":63,"name":"Brand","active":true,"attackRank":2,"defenseRank":2,"magicRank":9,"difficultyRank":6,"botEnabled":false,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":51,"name":"Caitlyn","active":true,"attackRank":8,"defenseRank":2,"magicRank":2,"difficultyRank":4,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":69,"name":"Cassiopeia","active":true,"attackRank":2,"defenseRank":3,"magicRank":9,"difficultyRank":10,"botEnabled":false,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":31,"name":"Chogath","active":true,"attackRank":3,"defenseRank":7,"magicRank":7,"difficultyRank":7,"botEnabled":true,"freeToPlay":false,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":42,"name":"Corki","active":true,"attackRank":8,"defenseRank":3,"magicRank":6,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true}]}');

		Api::setKey('key', $this->client);
		Champion::all();
		$this->assertTrue(Champion::get('blitzcrank') instanceof LeagueWrap\Response\Champion);
	}

	public function testFree()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.1/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn('{"champions":[{"id":103,"name":"Ahri","active":true,"attackRank":3,"defenseRank":4,"magicRank":8,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":51,"name":"Caitlyn","active":true,"attackRank":8,"defenseRank":2,"magicRank":2,"difficultyRank":4,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":42,"name":"Corki","active":true,"attackRank":8,"defenseRank":3,"magicRank":6,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":105,"name":"Fizz","active":true,"attackRank":6,"defenseRank":4,"magicRank":7,"difficultyRank":8,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":121,"name":"Khazix","active":true,"attackRank":9,"defenseRank":4,"magicRank":3,"difficultyRank":7,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":99,"name":"Lux","active":true,"attackRank":2,"defenseRank":4,"magicRank":9,"difficultyRank":6,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":33,"name":"Rammus","active":true,"attackRank":4,"defenseRank":10,"magicRank":5,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":107,"name":"Rengar","active":true,"attackRank":7,"defenseRank":4,"magicRank":2,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":false,"rankedPlayEnabled":true},{"id":44,"name":"Taric","active":true,"attackRank":4,"defenseRank":8,"magicRank":5,"difficultyRank":3,"botEnabled":true,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true},{"id":77,"name":"Udyr","active":true,"attackRank":8,"defenseRank":7,"magicRank":4,"difficultyRank":5,"botEnabled":false,"freeToPlay":true,"botMmEnabled":true,"rankedPlayEnabled":true}]}');

		Api::setKey('key', $this->client);
		$free = Champion::free();
		$this->assertEquals(10, count($free));
	}
}
