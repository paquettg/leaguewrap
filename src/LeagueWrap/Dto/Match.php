<?php

namespace LeagueWrap\Dto;


class Match extends AbstractDto {

    /**
     * Set up the information about this match.
     *
     * @param array $info
     */
    public function __construct(array $info)
    {

        // set participants
        if ( ! isset($info['participants']))
        {
            // solo game
            $info['participants'] = [];
        }
        $raw_participants = $info['participants'];
        $participants       = [];
        foreach ($raw_participants as $key => $value)
        {
            $participant        = new Participant($value);
            $participants[$participant->participantId] = $participant;
        }
        $info['participants'] = $participants;

        // set identities
        if ( ! isset($info['participantIdentities']))
        {
            // solo game
            $info['participantIdentities'] = [];
        }
        $raw_participant_identities = $info['participantIdentities'];
        $participant_identities     = [];
        foreach ($raw_participant_identities as $key => $value)
        {
            $identity        = new ParticipantIdentity($value);
            $participant_identities[$identity->participantId] = $identity;
        }
        $info['participantIdentities'] = $participant_identities;

        // set teams (match api)
        if(isset($info['teams']))
        {
            $raw_teams = $info['teams'];
            $teams = [];
            foreach($raw_teams as $key => $raw_team)
            {
                $teams[$key] = new MatchTeam($raw_team);
            }
            $info['teams'] = $teams;
        }

        parent::__construct($info);
    }

    /**
     * Attempts to get a participant from this match.
     *
     * @param int $id
     * @return Participant|null
     */
    public function participant($id)
    {
        if ( ! isset($this->info['participants']))
        {
            // no players
            return null;
        }
        $participant = $this->info['participants'];
        if (isset($participant[$id]))
        {
            return $participant[$id];
        }
        return null;
    }

    /**
     * Attempts to get a participant identity from this match.
     *
     * @param int $id
     * @return ParticipantIdentity|null
     */
    public function identity($id)
    {
        if ( ! isset($this->info['participantIdentities']))
        {
            // no players
            return null;
        }
        $identity = $this->info['participantIdentities'];
        if (isset($identity[$id]))
        {
            return $identity[$id];
        }
        return null;
    }
}

/**
 * Class MatchTeam
 * @package LeagueWrap\Dto
 * Team of a Match
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
}


/**
 * Class Ban
 * @package LeagueWrap\Dto
 * Represents a single ban
 */
class Ban extends AbstractDto{}
