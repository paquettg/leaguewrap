<?php

class DtoMatchListTest extends PHPUnit_Framework_TestCase {

    public function testMatchNoResults()
    {
        $matchList = new LeagueWrap\Dto\MatchList([]);
        $this->assertEquals(null, $matchList->match(1));
    }

    public function testSetMatchOutOfController()
    {
        $matchList = new LeagueWrap\Dto\MatchList([]);
        $matchList['matches'] = [];
        $this->assertTrue(isset($matchList['matches']));
    }

    public function testUnsetMatchOutOfController()
    {
        $matchList = new LeagueWrap\Dto\MatchList([]);
        $matchList['matches'] = [];
        unset($matchList['matches']);
        $this->assertFalse(isset($matchList['matches']));
    }
}