<?php
namespace LeagueWrap\Response\Team;

use LeagueWrap\Response;
use LeagueWrap\Response\Dto;

class Roster extends Dto {

	public function __construct(array $info)
	{
		$memberList = $info['memberList'];
		$members    = [];
		foreach ($memberList as $member)
		{
			$member                     = new Member($member);
			$members[$member->playerId] = $member;
		}
		$info['memberList'] = $members;

		$this->info = $info;
	}

	/**
	 * Attempts to get a member by the member id.
	 *
	 * @return null|Member
	 */
	public function member($id)
	{
		if (isset($this->info['memberList'][$id]))
		{
			return $this->info['memberList'][$id];
		}
		// could not find the member
		return null;
	}
}
