<?php

use LeagueWrap\Api;
use Mockery as m;

class SummonerTest extends PHPUnit_Framework_TestCase {

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

	public function testGetChampionDefault()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'api_key'  => 'key',
						'dataById' => 'true',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/champion.json'));

		$api       = new Api('key', $this->client);
		$champions = $api->staticData()->getChampions();
		$champion  = $champions->getChampion(53);
		$this->assertEquals('Blitzcrank', $champion->name);
	}

	public function testGetChampionRegionFR()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'api_key'  => 'key',
						'dataById' => 'true',
						'locale'   => 'fr_FR',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/champion.fr.json'));

		$api       = new Api('key', $this->client);
		$champions = $api->staticData()->setLocale('fr_FR')
		                               ->getChampions();
		$champion  = $champions->getChampion(69);
		$this->assertEquals('Étreinte du serpent', $champion->title);
	}

	public function testGetChampionById()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion/266', [
						'api_key' => 'key',
						'locale'  => 'fr_FR',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/champion.266.fr.json'));

		$api       = new Api('key', $this->client);
		$champion = $api->staticData()->setLocale('fr_FR')
		                              ->getChampion(266);
		$this->assertEquals('Aatrox', $champion->name);
	}

	public function testGetChampionTags()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'api_key'   => 'key',
						'dataById'  => 'true',
						'locale'    => 'fr_FR',
						'champData' => 'tags',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/champion.fr.tags.json'));

		$api       = new Api('key', $this->client);
		$champions = $api->staticData()->setLocale('fr_FR')
		                               ->getChampion('all', 'tags');
		$champion  = $champions->getChampion(412);
		$this->assertEquals('Support', $champion->tags[0]);
	}

	public function testGetChampionAll()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'api_key'   => 'key',
						'dataById'  => 'true',
						'champData' => 'all',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/champion.all.json'));

		$api       = new Api('key', $this->client);
		$champions = $api->staticData()->getChampions('all');
		$champion  = $champions->getChampion(412);
		$this->assertEquals('beginner_Starter', $champion->recommended[0]->blocks[0]->type);
	}
}

