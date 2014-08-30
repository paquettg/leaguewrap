<?php

use LeagueWrap\Api;
use \Mockery as m;

class StaticdataTest extends PHPUnit_Framework_TestCase{

    protected $client;

    public function setUp()
    {
        $this->client = m::mock('LeagueWrap\Client');

    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * Helper function to access a protected method
     * @param $class string classname
     * @param $name string method name
     * @return ReflectionMethod
     */
    private function getMethod($class, $name)
    {
        $rClass = new ReflectionClass($class);
        $method = $rClass->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    public function testAppendId()
    {
        $method = $this->getMethod('LeagueWrap\Api\Staticdata', 'appendId');

        $api = new Api('key', $this->client);
        $staticData = $api->staticData();

        // test various params
        $this->assertTrue($method->invoke($staticData, 1));
        $this->assertFalse($method->invoke($staticData, null));
        $this->assertFalse($method->invoke($staticData, 'all'));
    }



    public function testSetUpParamsAll()
    {
        $method = $this->getMethod('LeagueWrap\Api\Staticdata', 'setUpParams');

        $api = new Api('key', $this->client);
        $staticData = $api->staticData();

        $params = $method->invoke($staticData, '',  null, null, 'champData', 'champData');
        $expected = [
        ];
        $this->assertEquals($expected, $params);
    }

    public function testSetUpParamsAllData()
    {
        $method = $this->getMethod('LeagueWrap\Api\Staticdata', 'setUpParams');

        $api = new Api('key', $this->client);
        $staticData = $api->staticData();

        $params = $method->invoke($staticData, '',  null, 'all', 'listData', 'itemData');
        $expected = [
            'listData' => 'all'
        ];
        $this->assertEquals($expected, $params);
    }

    public function testSetUpParamsId()
    {
        $method = $this->getMethod('LeagueWrap\Api\Staticdata', 'setUpParams');

        $api = new Api('key', $this->client);
        $staticData = $api->staticData();

        $params = $method->invoke($staticData, '',  1, null, 'listData', 'itemData');
        $expected = [];
        $this->assertEquals($expected, $params);
    }

    public function testSetUpParamsIdData()
    {
        $method = $this->getMethod('LeagueWrap\Api\Staticdata', 'setUpParams');

        $api = new Api('key', $this->client);
        $staticData = $api->staticData();

        $params = $method->invoke($staticData, '',  1, 'all', 'listData', 'itemData');
        $expected = [
            'itemData' => 'all'
        ];
        $this->assertEquals($expected, $params);
    }

    public function testSetUpParamsDataById()
    {
        $method = $this->getMethod('LeagueWrap\Api\Staticdata', 'setUpParams');

        $api = new Api('key', $this->client);
        $staticData = $api->staticData();

        $params = $method->invoke($staticData, 'champion',  null, 'all', 'listData', 'itemData');
        $expected = [
            'dataById' => 'true',
            'listData' => 'all'
        ];
        $this->assertEquals($expected, $params);
    }

    public function testLanguage()
    {
        $method = $this->getMethod('LeagueWrap\Api\Staticdata', 'setUpParams');

        $api = new Api('key', $this->client);
        $staticData = $api->staticData();
        $staticData->setLocale('fr_FR');


        $params = $method->invoke($staticData, 'champion',  266, 'tags', 'champData', 'champData');
        $expected = [
            'locale'=> 'fr_FR',
            'champData' => 'tags'
        ];
        $this->assertEquals($expected, $params);
    }


} 