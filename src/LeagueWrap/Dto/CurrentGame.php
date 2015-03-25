<?php
namespace LeagueWrap\Dto;

class CurrentGame extends AbstractDto
{
    /**
     * Set up the information about this game.
     *
     * @param array $info
     */
    public function __construct(array $info)
    {
        // set bans
        if ( ! isset($info['bannedChampions']))
        {
            // no bans in this game
            $info['bannedChampions'] = [];
        }
        $rawBans = $info['bannedChampions'];
        $bans    = [];
        foreach ($rawBans as $value)
        {
            $ban = new Ban($value);
            $bans[$ban->pickTurn] = $ban;
        }
        $info['bannedChampions'] = $bans;

        // set observer
        if(isset($info['observers']))
            $info['observers'] = new Observer($info['observers']);

        // set participants
        if ( ! isset($info['participants']))
        {
            $info['participants'] = [];
        }
        $rawParticipants = $info['participants'];
        $participants    = [];
        foreach ($rawParticipants as $value)
        {
            $participant                            = new CurrentGameParticipant($value);
            $participants[$participant->summonerId] = $participant;
        }
        $info['participants'] = $participants;

        parent::__construct($info);
    }

    /**
     * get a ban from the current game
     * @param $pickTurn
     * @return \LeagueWrap\Dto\Ban
     */
    public function ban($pickTurn)
    {
        $bans = $this->info['bannedChampions'];
        if (isset($bans[$pickTurn]))
        {
            return $bans[$pickTurn];
        }
        return null;
    }

    /**
     * @param $participantId get a participant by its summoner id
     * @return \LeagueWrap\Dto\CurrentGameParticipant
     */
    public function participant($summonerId)
    {
        $participant = $this->info['participants'];
        if (isset($participant[$summonerId]))
        {
            return $participant[$summonerId];
        }
        return null;
    }
}
