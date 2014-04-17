<?php

use LeagueWrap\Region;

class RegionTest extends PHPUnit_Framework_TestCase {
	
	public function testIsLocked()
	{
		$region = new Region('euw');
		$this->assertTrue($region->isLocked(['na']));
	}

	public function testIsLockedFalse()
	{
		$region = new Region('euw');
		$this->assertFalse($region->isLocked([
			'na',
			'euw',
			'eune',
		]));
	}

	public function testGetDomainDefault()
	{
		$region = new Region('rawr');
		$this->assertEquals('https://prod.api.pvp.net/api/lol/', $region->getDomain());
	}

	public function testGetDomainStaticData()
	{
		$region = new Region('na');
		$this->assertEquals('https://prod.api.pvp.net/api/lol/static-data/', $region->getDomain(true));
	}
}
