<?php

use LeagueWrap\Limit\Limit;

class LimitLimitTest extends PHPUnit_Framework_TestCase {

	public function testSetRate()
	{
		$limit  = new Limit;
		$status = $limit->setRate(10, 10);
		$this->assertTrue($status);
	}

	public function testHit()
	{
		$limit = new Limit;
		$limit->setRate(10, 10);
		$limit->hit();
		$this->assertEquals(9, $limit->remaining());
	}

	public function testHitFour()
	{
		$limit = new Limit;
		$limit->setRate(10, 10);
		$limit->hit(4);
		$this->assertEquals(6, $limit->remaining());
	}

	public function testSetRates()
	{
		$limit = new Limit;
		$limit->setRate(10, 10);
		$limit->setRate(5, 5);
		$limit->hit();
		$this->assertEquals(4, $limit->remaining());
	}
}
