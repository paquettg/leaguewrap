<?php
namespace LeagueWrap\Dto\Team;

use LeagueWrap\Dto\AbstractListDto;

class Roster extends AbstractListDto {

	protected $listKey = 'memberList';

    /**
     * Set up the information about this response.
     *
     * @param array $info
     */
    public function __construct(array $info)
	{
		if (isset($info['memberList']))
		{
			$members = [];
			foreach ($info['memberList'] as $member)
			{
				$member                     = new Member($member);
				$members[$member->playerId] = $member;
			}
			$info['memberList'] = $members;
		}

		parent::__construct($info);
	}

	/**
	 * Attempts to get a member by the member id.
	 *
     * @param int $memberId
	 * @return null|Member
	 */
	public function member($memberId)
	{
		if (isset($this->info['memberList'][$memberId]))
		{
			return $this->info['memberList'][$memberId];
		}
		// could not find the member
		return null;
	}
}
