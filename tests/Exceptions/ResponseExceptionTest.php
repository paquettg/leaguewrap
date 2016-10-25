<?php

use LeagueWrap\Api;
use LeagueWrap\Exception\NoResponseIncludedException;
use LeagueWrap\Response;
use LeagueWrap\Response\Http404;
use LeagueWrap\Response\Http429;
use LeagueWrap\Response\ResponseException;
use LeagueWrap\Response\UnderlyingServiceRateLimitReached;
use Mockery as m;

class ResponseExceptionTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $client = m::mock('LeagueWrap\Client');
        $this->client = $client;
    }

    public function tearDown()
    {
        m::close();
    }

    private function simulateWithResponse(Response $response)
    {
        $this->client->shouldReceive('baseUrl')->with('https://na.api.pvp.net/api/lol/na/')
            ->once();
        $this->client->shouldReceive('request')
            ->with('v1.2/champion', [
                'freeToPlay' => 'false',
                'api_key' => 'key',
            ])->once()
            ->andReturn($response);
    }

    public function testHttp429ExceptionContainsResponse()
    {
        try {
            $this->simulateWithResponse(new Response('', 429, [
                'Retry-After' => [
                    123
                ],
                'X-Rate-Limit-Type' => [
                    'user'
                ],
            ]));

            $api = new Api('key', $this->client);
            $api->champion()->all();
        } catch (ResponseException $e) {
            $this->assertTrue($e->hasResponse());
            $this->assertInstanceOf(Http429::class, $e);
            $this->assertInstanceOf(Response::class, $e->getResponse());

            $this->assertTrue($e->getResponse()->hasHeader('Retry-After'));
            $this->assertTrue($e->getResponse()->hasHeader('X-Rate-Limit-Type'));
            $this->assertFalse($e->getResponse()->hasHeader('that does not exist'));

            $this->assertCount(2, $e->getResponse()->getHeaders());
            $this->assertEquals([
                'Retry-After' => 123,
                'X-Rate-Limit-Type' => 'user',
            ], $e->getResponse()->getHeaders());

            $this->assertEquals(123, $e->getResponse()->getHeader('Retry-After'));
            $this->assertEquals('user', $e->getResponse()->getHeader('X-Rate-Limit-Type'));
            $this->assertNull($e->getResponse()->getHeader('that does not exist'));
        }
    }

    public function testUnderlyingServiceExceptionContainsResponse()
    {
        try {
            $this->simulateWithResponse(new Response('', 429, []));

            $api = new Api('key', $this->client);
            $api->champion()->all();
        } catch (ResponseException $e) {
            $this->assertTrue($e->hasResponse());
            $this->assertInstanceOf(UnderlyingServiceRateLimitReached::class, $e);
            $this->assertInstanceOf(Response::class, $e->getResponse());

            $this->assertFalse($e->getResponse()->hasHeader('Retry-After'));
            $this->assertFalse($e->getResponse()->hasHeader('X-Rate-Limit-Type'));

            $this->assertCount(0, $e->getResponse()->getHeaders());
            $this->assertEquals([], $e->getResponse()->getHeaders());

            $this->assertNull($e->getResponse()->getHeader('Retry-After'));
            $this->assertNull($e->getResponse()->getHeader('X-Rate-Limit-Type'));
        }
    }

    public function testExceptionDoesNotContainResponse()
    {
        $this->setExpectedException(NoResponseIncludedException::class);

        $e = new Http404('Oops.', 404);
        $response = $e->getResponse();
    }
}
