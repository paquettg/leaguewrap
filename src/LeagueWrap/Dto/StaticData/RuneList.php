<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractListDto;

class RuneList extends AbstractListDto {

	protected $listKey = 'data';

	public function __construct(array $info)
	{
		if (isset($info['basic']))
		{
			$info['basic'] = new BasicData($info['basic']);
		}
		if (isset($info['data']))
		{
			$runes = [];
			foreach ($info['data'] as $id => $rune)
			{
				$runeDto    = new Rune($rune);
				$runes[$id] = $runeDto;
			}
			$info['data'] = $runes;
		}

		parent::__construct($info);
	}

	/**
	 * Quick shortcut to get the rune information by $id
	 *
	 * @param int $id
	 * @return Rune|null
	 */
	public function getRune($id)
	{
		if (isset($this->info['data'][$id]))
		{
			return $this->info['data'][$id];
		}

		return null;
	}
}


