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
			foreach ($info['data'] as $id => $item)
			{
				$itemDto   = new Item($item);
				$data[$id] = $itemDto;
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
			foreach ($info['groups'] as $id => $group)
			{
				$groupDto    = new Group($group);
				$groups[$id] = $groupDto;
			}
			$info['groups'] = $groups;
		}
		if (isset($info['tree']))
		{
			$tree = [];
			foreach ($info['tree'] as $id => $tree)
			{
				$itemTreeDto = new ItemTree($tree);
				$tree[$id]   = $itemTreeDto;
			}
			$info['tree'] = $tree;
		}

		parent::__construct($info);
	}

	/**
	 * Quick shortcut to get a champions information by $id
	 *
	 * @param int $id
	 * @return Champion|null
	 */
	public function getItem($id)
	{
		if (isset($this->info['data'][$id]))
		{
			return $this->info['data'][$id];
		}

		return null;
	}
}
