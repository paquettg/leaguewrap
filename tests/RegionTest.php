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

    public function testGetDomain()
    {
        $region = new Region('euw');
        $this->assertEquals('https://euw.api.pvp.net/api/lol/', $region->getDomain());
    }

	public function testGetDomainStaticData()
	{
		$region = new Region('na');
		$this->assertEquals('https://global.api.pvp.net/api/lol/static-data/', $region->getDomain(true));
		$this->assertEquals('https://global.api.pvp.net/api/lol/static-data/', $region->getStaticDataDomain());
	}

	public function testGetObserverDomain()
	{
		$region = new Region('na');
		$this->assertEquals('https://na.api.pvp.net/observer-mode/rest/', $region->getObserverDomain());
	}
}
