<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class SummonerSpell extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['image']))
		{
			$info['image'] = new Image($info['image']);
		}
		if (isset($info['leveltip']))
		{
			$info['leveltip'] = new LevelTip($info['leveltip']);
		}
		if (isset($info['vars']))
		{
			$vars = [];
			foreach ($info['vars'] as $id => $var)
			{
				$spellVarDto = new SpellVar($var);
				$vars[$id]   = $spellVarDto;
			}
			$info['vars'] = $vars;
		}

		parent::__construct($info);
	}
}
