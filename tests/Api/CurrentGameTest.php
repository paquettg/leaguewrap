<?php


use LeagueWrap\Api;
use Mockery as m;

class CurrentGameTest extends PHPUnit_Framework_TestCase
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

	public function testCurrentGame()
	{
		$this->client->shouldReceive('baseUrl')
			->once();
		$this->client->shouldReceive('request')
			->with('consumer/getSpectatorGameInfo/EUW1/30447079', [
				'api_key' => 'key',
			])->once()
			->andReturn(file_get_contents('tests/Json/currentgame.30447079.json'));

		$api = new Api('key', $this->client);
		$api->setRegion('euw');
		$game = $api->currentGame()->currentGame(30447079);
		$this->assertTrue($game instanceof LeagueWrap\Dto\CurrentGame);
	}
}