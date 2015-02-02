<?php

use Mockery as m;

class ClientTest extends PHPUnit_Framework_TestCase {

	public function teatDown()
	{
		m::close();
	}

	public function testRequest()
	{
		$response = new GuzzleHttp\Message\Response(200, ['X-Foo' => 'Bar']);
		$response->setBody(GuzzleHttp\Stream\Stream::factory('foo'));
		$mock = new GuzzleHttp\Subscriber\Mock([
			$response,
		]);

		$client = new LeagueWrap\Client;
		$client->baseUrl('http://google.com');
		$client->setTimeout(10);
		$client->addMock($mock);
		$response = $client->request('', []);
		$this->assertEquals('foo', $response);
	}

	/**
	 * @expectedException LeagueWrap\Exception\BaseUrlException 
	 */
	public function testRequestNoBaseUrl()
	{
		$client = new LeagueWrap\Client;
		$client->request('', []);
	}
}
