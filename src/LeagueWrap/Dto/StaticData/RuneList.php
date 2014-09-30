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
			foreach ($info['data'] as $runeId => $rune)
			{
				$runeDto        = new Rune($rune);
				$runes[$runeId] = $runeDto;
			}
			$info['data'] = $runes;
		}

		parent::__construct($info);
	}

	/**
	 * Quick shortcut to get the rune information by $runeId
	 *
	 * @param int $runeId
	 * @return Rune|null
	 */
	public function getRune($runeId)
	{
		if (isset($this->info['data'][$runeId]))
		{
			return $this->info['data'][$runeId];
		}

		return null;
	}
}


