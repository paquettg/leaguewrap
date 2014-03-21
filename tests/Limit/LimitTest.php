<?php

use LeagueWrap\Limit\Limit;

class LimitLimitTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		if ( ! extension_loaded('memcached')) 
		{
		    $this->markTestSkipped('The memcached extension is not available.');
		}
		$memcached = new Memcached;
		if ( ! $memcached->addServer('localhost', 11211, 100))
		{
			$this->markTestSkipped('Could not connect to localhost server 11211.');
		}
		if ( ! $memcached->flush())
		{
			$code = $memcached->getResultCode();
			$this->markTestSkipped('Could not flush memcached (code #'.$code.')');
		}
	}

	public function testSetRate()
	{
		$limit  = new Limit;
		$status = $limit->setRate(10, 10);
		$this->assertTrue($status);
	}

	public function testHit()
	{
		$limit = new Limit;
		$limit->setRate(11, 11);
		$status = $limit->hit();
		$this->assertTrue($status);
	}

	public function testHitRemaining()
	{
		$limit = new Limit;
		$limit->setRate(10, 11);
		$limit->hit();
		$this->assertEquals(9, $limit->remaining());
	}

	public function testHitFour()
	{
		$limit = new Limit;
		$limit->setRate(11, 12);
		$status = $limit->hit(4);
		$this->assertTrue($status);
	}

	public function testHitFourRemaining()
	{
		$limit = new Limit;
		$limit->setRate(10, 12);
		$limit->hit(4);
		$this->assertEquals(6, $limit->remaining());
	}
}
