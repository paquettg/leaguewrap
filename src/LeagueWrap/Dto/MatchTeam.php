<?php


namespace LeagueWrap\Dto;

/**
 * Class MatchTeam
 * @package LeagueWrap\Dto
 * Team of a match
 */
class MatchTeam extends AbstractDto{
    /**
     * Set up the information about this team.
     *
     * @param array $info
     */
    public function __construct(array $info)
    {
        // set teams (match api)
        if(isset($info['bans']))
        {
            $raw_bans = $info['bans'];
            $bans = [];
            foreach($raw_bans as $key => $raw_ban)
            {
                $bans[$key] = new Ban($raw_ban);
            }
            $info['bans'] = $bans;
        }

        parent::__construct($info);
    }

    /**
     * Attempts to get a ban from this team.
     *
     * @param int $id
     * @return Ban|null
     */
    public function ban($id)
    {
        if ( ! isset($this->info['bans']))
        {
            // no teams
            return null;
        }
        $bans = $this->info['bans'];
        if (isset($bans[$id]))
        {
            return $bans[$id];
        }
        return null;
    }
}