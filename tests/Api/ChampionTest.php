<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiChampionTest extends PHPUnit_Framework_TestCase {

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

	public function testAll()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(new LeagueWrap\Response(file_get_contents('tests/Json/champion.json'), 200));

		$api       = new Api('key', $this->client);
		$champion  = $api->champion();
		$champions = $champion->all();
		$this->assertTrue($champions->getChampion(53) instanceof LeagueWrap\Dto\Champion);
	}

	public function testAllArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.json'));

		$api       = new Api('key', $this->client);
		$champion  = $api->champion();
		$champions = $champion->all();
		$this->assertTrue($champions[53] instanceof LeagueWrap\Dto\Champion);
	}

	public function testFreeWillNotBeStoredPermanently() 
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.json'));

	    $api      = new Api('key', $this->client);
	    $champion = $api->champion();
	    $this->assertNotEquals($champion->free(), $champion->all());
	}

	public function testAllIterator()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.json'));

		$api       = new Api('key', $this->client);
		$champion  = $api->champion();
		$champions = $champion->all();
		$count     = 0;
		foreach ($champions as $champion)
		{
			++$count;
		}
		$this->assertEquals(count($champions), $count);
	}

	public function testFree()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api  = new Api('key', $this->client);
		$free = $api->champion()->free();
		$this->assertEquals(10, count($free->champions));
	}

	public function testFreeCountable()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'true',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.free.json'));

		$api  = new Api('key', $this->client);
		$free = $api->champion()->free();
		$this->assertEquals(10, count($free));
	}

	public function testChampionById()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion/10', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.10.json'));

		$api   = new Api('key', $this->client);
		$kayle = $api->champion()->championById(10);
		$this->assertEquals(true, $kayle->rankedPlayEnabled);
	}

	public function testChampionByIdWithStaticImport()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion/10', [
						'api_key' => 'key',
		             ])->twice()
		             ->andReturn(file_get_contents('tests/Json/champion.10.json'),
		                         file_get_contents('tests/Json/Static/champion.10.json'));

		$api = new Api('key', $this->client);
		$kayle = $api->attachStaticData()->champion()->championById(10);
		$this->assertEquals('Kayle', $kayle->championStaticData->name);
	}

	public function testAllRegionKR()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once()
		             ->with('https://kr.api.pvp.net/api/lol/');
		$this->client->shouldReceive('request')
		             ->with('kr/v1.2/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.kr.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('kr');
		$champion  = $api->champion();
		$champions = $champion->all();
		$this->assertTrue($champions->getChampion(53) instanceof LeagueWrap\Dto\Champion);
	}

	public function testAllRegionRU()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once()
		             ->with('https://ru.api.pvp.net/api/lol/');
		$this->client->shouldReceive('request')
		             ->with('ru/v1.2/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/champion.ru.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('RU');
		$champion  = $api->champion();
		$champions = $champion->all();
		$this->assertTrue($champions->getChampion(53) instanceof LeagueWrap\Dto\Champion);
	}

	/**
	 * @expectedException LeagueWrap\Response\Http400
	 * @expectedExceptionMessage Bad request.
	 */
	public function testAllBadRquest()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/champion', [
						'freeToPlay' => 'false',
						'api_key'    => 'key',
		             ])->once()
		             ->andReturn(new LeagueWrap\Response('', 400));

		$api       = new Api('key', $this->client);
		$champion  = $api->champion();
		$champions = $champion->all();
	}
}

