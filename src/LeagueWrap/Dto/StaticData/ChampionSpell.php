<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class ChampionSpell extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['image']))
		{
			$info['image'] = new Image($info['image']);
		}
		if (isset($info['altimages']))
		{
			$altImages = [];
			foreach ($info['altimages'] as $key => $image)
			{
				$altImages[$key] = new Image($image);
			}
			$info['altimages'] = $altImages;
		}
		if (isset($info['leveltip']))
		{
			$info['leveltip'] = new LevelTip($info['leveltip']);
		}
		if (isset($info['vars']))
		{
			$vars = [];
			foreach ($info['vars'] as $key => $var)
			{
				$vars[$key] = new SpellVar($var);
			}
			$info['vars'] = $vars;
		}

		parent::__construct($info);
	}
}
