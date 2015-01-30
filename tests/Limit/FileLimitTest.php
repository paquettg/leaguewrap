<?php

use LeagueWrap\Limit\FileLimit;

class LimitFileLimitTest extends PHPUnit_Framework_TestCase {

	public function testSetRate()
	{
		$this->markTestSkipped();
		$limit = new FileLimit;
		$chain = $limit->setRate(10, 10, 'na');
		$this->assertEquals($chain, $limit);
	}

	public function testHit()
	{
		$this->markTestSkipped();
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'ru');
		$status = $limit->hit();
		$this->assertTrue($status);
	}

	public function testHitRemaining()
	{
		$this->markTestSkipped();
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'eune');
		$limit->hit();
		$this->assertEquals(9, $limit->remaining());
	}

	public function testHitFour()
	{
		$this->markTestSkipped();
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'euw');
		$status = $limit->hit(4);
		$this->assertTrue($status);
	}

	public function testHitFourRemaining()
	{
		$this->markTestSkipped();
		$limit = new FileLimit;
		$limit->setRate(10, 10, 'br');
		$limit->hit(4);
		$this->assertEquals(6, $limit->remaining());
	}

	public function testNewInstance()
	{
		$this->markTestSkipped();
		$limit    = new FileLimit;
		$newLimit = $limit->newInstance();
		$this->assertTrue($newLimit instanceof FileLimit);
	}

	public function testRemainingWithOutFile()
	{
		$this->markTestSkipped();
		$limit = new FileLimit;
		$limit->setRate(100, 100, 'na');
		$this->assertEquals(100, $limit->remaining());
	}

	public function testTimeRunOut()
	{
		$this->markTestSkipped();
		$limit = new FileLimit;
		$limit->setRate(8, 0, 'euna');
		$limit->hit(8);
		$this->assertEquals(8, $limit->remaining());
	}
}
