<?php

use LeagueWrap\Region;

class RegionTest extends PHPUnit_Framework_TestCase {
	
	public function testIsLocked()
	{
		$region = new Region([
			'na',
		]);

		$this->assertTrue($region->isLocked('euw'));
	}

	public function testIsLockedFalse()
	{
		$region = new Region([
			'na',
			'euw',
			'eune',
		]);

		$this->assertFalse($region->isLocked('euw'));
	}
}
