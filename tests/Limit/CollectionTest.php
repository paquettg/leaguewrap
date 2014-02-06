<?php

use LeagueWrap\Limit\Limit;
use LeagueWrap\Limit\Collection;

class LimitCollectionTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		if ( ! extension_loaded('memcached')) 
		{
		    $this->markTestSkipped('The memcached extension is not available.');
		}
	}

	public function testHitLimits()
	{
		$limit = new Limit;
		$limit->setRate(10, 2);
		$collection = new Collection;
		$collection->addLimit($limit);
		$hit = $collection->hitLimits();
		$this->assertTrue($hit);
	}

	public function testHitLimitsMultiple()
	{
		$limit1 = new Limit;
		$limit1->setRate(9, 2);
		$limit2 = new Limit;
		$limit2->setRate(5, 2);
		$collection = new Collection;
		$collection->addLimit($limit1);
		$collection->addLimit($limit2);
		$hit = $collection->hitLimits();
		$this->assertTrue($hit);
	}

	public function testHitLimitMultipleFail()
	{
		$limit1 = new Limit;
		$limit1->setRate(7, 2);
		$limit2 = new Limit;
		$limit2->setRate(3, 2);
		$collection = new Collection;
		$collection->addLimit($limit1);
		$collection->addLimit($limit2);
		$hit = $collection->hitLimits(4);
		$this->assertFalse($hit);
	}

	public function testRemainingHits()
	{
		$limit = new Limit;
		$limit->setRate(10, 3);
		$collection = new Collection;
		$collection->addLimit($limit);
		$collection->hitLimits(2);
		$this->assertEquals(8, $collection->remainingHits());
	}

	public function testRemainingHitsMultiple()
	{
		$limit1 = new Limit;
		$limit1->setRate(25, 10);
		$limit2 = new Limit;
		$limit2->setRate(2, 5);
		$collection = new Collection;
		$collection->addLimit($limit1);
		$collection->addLimit($limit2);
		$collection->hitLimits(1);
		$this->assertEquals(1, $collection->remainingHits());
	}
}
