<?php
namespace LeagueWrap\Dto;

class League extends AbstractDto {

	public function __construct(array $info)
	{
		$entries = $info['entries'];
		$items   = [];
		foreach ($entries as $key => $item)
		{
			$leagueItem  = new LeagueItem($item);
			$items[$key] = $leagueItem;
		}
		$info['entries']          = $items;
		$info['playerOrTeamName'] = null;

		$this->info = $info;

		// get the current team
		$current = $this->entry($this->info['id']);
		if ( ! is_null($current))
		{
			$this->info['playerOrTeam'] = $current;
		}
	}

	/**
	 * Select an entry by the team/summoner name or the team\summoner
	 * id.
	 *
	 * @param mixerd $identity
	 * @return LeagueItem|null
	 */
	public function entry($identity)
	{
		if ( ! isset($this->info['entries']))
		{
			return null;
		}

		$entries = $this->info['entries'];
		foreach ($entries as $entry)
		{
			// try the name
			if ($entry->playerOrTeamName == $identity)
			{
				return $entry;
			}
			// try the id
			if ($entry->playerOrTeamId == $identity)
			{
				return $entry;
			}
		}

		return null;
	}
}
