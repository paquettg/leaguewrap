<?php

use Mockery as m;

class ClientTest extends PHPUnit_Framework_TestCase {

	public function teatDown()
	{
		m::close();
	}

	public function testRequest()
	{
		$response = new GuzzleHttp\Psr7\Response(
			200,
			['X-Foo' => 'Bar'],
			GuzzleHttp\Psr7\stream_for('foo'));
		$mockedHandler = new GuzzleHttp\Handler\MockHandler([
			$response,
		]);
		$handlerStack = \GuzzleHttp\HandlerStack::create($mockedHandler);

		$client = new LeagueWrap\Client;
		$client->baseUrl('http://google.com');
		$client->setTimeout(10);
		$client->addMock($handlerStack);
		$response = $client->request('', []);
		$this->assertEquals('foo', $response);
		$this->assertEquals(200, $response->getCode());
		$this->assertTrue($response->hasHeader('X-Foo'));
		$this->assertFalse($response->hasHeader('Missing-Header'));
		$this->assertEquals('Bar', $response->getHeader('X-Foo'));
		$this->assertNull($response->getHeader('that does not exists'));
		$headers = $response->getHeaders();
		$this->assertArrayHasKey('X-Foo', $headers);
		$this->assertCount(1, $headers);
		$this->assertEquals('Bar', $headers['X-Foo']);
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
