<?php
namespace LeagueWrap\Dto;

class League extends AbstractListDto {

	protected $listKey = 'entries';

	public function __construct(array $info)
	{
		if (isset($info['entries']))
		{
			$entries = [];
			foreach ($info['entries'] as $key => $entry)
			{
				$leagueEntry = new LeagueEntry($entry);
				$entries[$key] = $leagueEntry;
			}
			$info['entries'] = $entries;
		}

		$info['playerOrTeamName'] = null;

		parent::__construct($info);

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
