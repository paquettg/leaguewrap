<?php
namespace LeagueWrap\Dto;

class FeaturedGames extends AbstractListDto {

	protected $listKey = 'gameList';

    /**
     * @param array $info
     */
    public function __construct(array $info)
	{
		if (isset($info['gameList']))
		{
			$games = [];
			foreach ($info['gameList'] as $game)
			{
				$gameDto = new CurrentGame($game);
				$games[] = $gameDto;
			}
			$info['gameList'] = $games;
		}

		parent::__construct($info);
	}
}
