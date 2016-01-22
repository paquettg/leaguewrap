<?php


use LeagueWrap\Dto\ShardStatus;

class ShardStatusTest extends PHPUnit_Framework_TestCase
{

	public function testParseShardStatus() {
		$content = json_decode(file_get_contents('tests/Json/shardstatus.euw.json'), true);
		$shardStatus = new ShardStatus($content);
		$this->assertTrue($shardStatus instanceof ShardStatus);
		$service = $shardStatus->services[0];
		$this->assertTrue($service instanceof \LeagueWrap\Dto\Service);

	}

	public function testGetServiceByName() {
		$content = json_decode(file_get_contents('tests/Json/shardstatus.euw.json'), true);
		$shardStatus = new ShardStatus($content);
		$service = $shardStatus->getService("Game");
		$this->assertTrue($service instanceof \LeagueWrap\Dto\Service);
		$this->assertEquals($service->slug, "game");
	}

	public function testGetTranslation() {
		$content = json_decode(file_get_contents('tests/Json/shardstatus.euw.json'), true);
		$shardStatus = new ShardStatus($content);
		$service = $shardStatus->getService("Game");
		$incident = $service->incidents[0];
		$message = $incident->updates[0];
		$translation = $message->getTranslationByLocale('de_DE');
		$this->assertTrue($translation instanceof \LeagueWrap\Dto\Translation);
		$this->assertTrue($translation->locale == "de_DE");
	}

}