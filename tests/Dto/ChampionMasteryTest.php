<?php

class DtoChampionMasteryTest extends PHPUnit_Framework_TestCase
{

    public function testChampionMasteryList() {
        $content = json_decode(file_get_contents('tests/Json/championmastery.30447079.1.json'), true);
        $mastery = new \LeagueWrap\Dto\ChampionMastery($content);

        $this->assertEquals($mastery->championId, 1);
        $this->assertEquals($mastery->lastPlayTime, 1443135919000);
    }

}