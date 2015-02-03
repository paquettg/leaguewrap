<?php

class DtoStaticDataBlockTest extends PHPUnit_Framework_TestCase {

	public function testItem()
	{
		$block = new LeagueWrap\Dto\StaticData\Block([
			'items' => [
				1 => [
					'name' => 'item1',
				],
				2 => [
					'name' => 'item2',
				],
				3 => [
					'name' => 'item3',
				],
			],
		]);

		$item = $block->item(2);
		$this->assertTrue($item instanceof LeagueWrap\Dto\StaticData\BlockItem);
	}

	public function testItemNotFound()
	{
		$block = new LeagueWrap\Dto\StaticData\Block([
			'items' => [
				1 => [
					'name' => 'item1',
				],
				2 => [
					'name' => 'item2',
				],
				3 => [
					'name' => 'item3',
				],
			],
		]);

		$item = $block->item(4);
		$this->assertTrue(is_null($item));
	}
}
