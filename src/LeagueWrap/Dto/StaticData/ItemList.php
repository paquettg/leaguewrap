<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractListDto;

class ItemList extends AbstractListDto {

	protected $listKey = 'data';

	/**
	 * Set up the information about the ItemList Dto.
	 *
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		if (isset($info['data']))
		{
			$data = [];
			foreach ($info['data'] as $itemId => $item)
			{
				$itemDto       = new Item($item);
				$data[$itemId] = $itemDto;
			}
			$info['data'] = $data;
		}
		if (isset($info['basic']))
		{
			$info['basic'] = new BasicData($info['basic']);
		}
		if (isset($info['groups']))
		{
			$groups = [];
			foreach ($info['groups'] as $itemId => $group)
			{
				$groupDto        = new Group($group);
				$groups[$itemId] = $groupDto;
			}
			$info['groups'] = $groups;
		}
		if (isset($info['tree']))
		{
			$tree = [];
			foreach ($info['tree'] as $itemId => $tree)
			{
				$itemTreeDto   = new ItemTree($tree);
				$tree[$itemId] = $itemTreeDto;
			}
			$info['tree'] = $tree;
		}

		parent::__construct($info);
	}

	/**
	 * Quick shortcut to get a champions information by $itemId
	 *
	 * @param int $itemId
	 * @return Champion|null
	 */
	public function getItem($itemId)
	{
		if (isset($this->info['data'][$itemId]))
		{
			return $this->info['data'][$itemId];
		}

		return null;
	}
}
