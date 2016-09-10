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
        $this->assertEquals('https://euw.api.pvp.net/api/lol/euw/', $region->getDefaultDomain());
    }

	public function testGetDomainStaticData()
	{
		$region = new Region('na');
		$this->assertEquals('https://global.api.pvp.net/api/lol/static-data/na/', $region->getStaticDataDomain());
	}

	public function testGetFeaturedGamesDomain()
	{
		$region = new Region('na');
		$this->assertEquals('https://na.api.pvp.net/observer-mode/rest/', $region->getFeaturedGamesDomain());
	}

	public function testGetCurrentGameDomain() {
		$region = new Region('euw');
		$this->assertEquals('https://euw.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/EUW1/', $region->getCurrentGameDomain());
	}

	public function testGetChampionMasteryDomain() {
		$region = new Region('euw');
		$this->assertEquals('https://euw.api.pvp.net/championmastery/location/EUW1/', $region->getChampionMasteryDomain());
	}


}
