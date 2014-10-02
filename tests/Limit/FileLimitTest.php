<?php

use LeagueWrap\Limit\FileLimit;

class LimitFileLimitTest extends PHPUnit_Framework_TestCase {

	public function testSetRate()
	{
		$limit = new FileLimit;
		$chain = $limit->setRate(10, 10, 'na');
		$this->assertEquals($chain, $limit);
	}

	public function testHit()
	{
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'ru');
		$status = $limit->hit();
		$this->assertTrue($status);
	}

	public function testHitRemaining()
	{
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'eune');
		$limit->hit();
		$this->assertEquals(9, $limit->remaining());
	}

	public function testHitFour()
	{
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'euw');
		$status = $limit->hit(4);
		$this->assertTrue($status);
	}

	public function testHitFourRemaining()
	{
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'br');
		$limit->hit(4);
		$this->assertEquals(6, $limit->remaining());
	}
}
