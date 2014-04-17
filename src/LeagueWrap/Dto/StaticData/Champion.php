<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class Champion extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['image']))
		{
			$info['image'] = new Image($info['image']);
		}
		if (isset($info['info']))
		{
			$info['info'] = new Info($info['info']);
		}
		if (isset($info['passive']))
		{
			$info['passive'] = new Passive($info['passive']);
		}
		if (isset($info['recommended']))
		{
			$recommended = [];
			foreach ($info['recommended'] as $key => $value)
			{
				$recommended[$key] = new Recommended($value);
			}
			$info['recommended'] = $recommended;
		}
		if (isset($info['skins']))
		{
			$skins = [];
			foreach ($info['skins'] as $key => $skin)
			{
				$skins[$key] = new Skin($skin);
			}
			$info['skins'] = $skins;
		}
		if (isset($info['spells']))
		{
			$spells = [];
			foreach ($info['spells'] as $key => $spell)
			{
				$spells[$key] = new ChampionSpell($spell);
			}
			$info['spells'] = $spells;
		}
		if (isset($info['stats']))
		{
			$info['stats'] = new Stats($info['stats']);
		}

		parent::__construct($info);
	}
}
