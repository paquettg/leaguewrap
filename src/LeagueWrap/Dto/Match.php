<?php

namespace LeagueWrap\Dto;

/**
 * Class Match
 * @package LeagueWrap\Dto
 * Match (MatchHistory api and match-by-id api)
 */
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
        $rawParticipants = $info['participants'];
        $participants    = [];
        foreach ($rawParticipants as $value)
        {
            $participant                               = new Participant($value);
            $participants[$participant->participantId] = $participant;
        }
        $info['participants'] = $participants;

        // set identities
        if ( ! isset($info['participantIdentities']))
        {
            // solo game
            $info['participantIdentities'] = [];
        }
        $rawrParticipantIds = $info['participantIdentities'];
        $participantIds     = [];
        foreach ($rawrParticipantIds as $value)
        {
            $identity                                 = new ParticipantIdentity($value);
            $participantIds[$identity->participantId] = $identity;
        }
        $info['participantIdentities'] = $participantIds;

        // set teams (only for match api)
        if(isset($info['teams']))
        {
            $rawTeams = $info['teams'];
            $teams    = [];
            foreach($rawTeams as $key => $rawTeam)
            {
                $teams[$key] = new MatchTeam($rawTeam);
            }
            $info['teams'] = $teams;
        }

        if(isset($info['timeline']))
        {
            $info['timeline'] = new MatchTimeline($info['timeline']);
        }

        parent::__construct($info);
    }

    /**
     * Attempts to get a participant from this match.
     *
     * @param int $participantId
     * @return Participant|null
     */
    public function participant($participantId)
    {
        if ( ! isset($this->info['participants']))
        {
            // no players
            return null;
        }
        $participant = $this->info['participants'];
        if (isset($participant[$participantId]))
        {
            return $participant[$participantId];
        }
        return null;
    }

    /**
     * Attempts to get a participant identity from this match.
     *
     * @param int $participantId
     * @return ParticipantIdentity|null
     */
    public function identity($participantId)
    {
        if ( ! isset($this->info['participantIdentities']))
        {
            // no players
            return null;
        }
        $participantIdentity = $this->info['participantIdentities'];
        if (isset($participantIdentity[$participantId]))
        {
            return $participantIdentity[$participantId];
        }
        return null;
    }

    /**
     * Attempts to get a team from this match.
     *
     * @param int $teamId
     * @return Team|null
     */
    public function team($teamId)
    {
        if ( ! isset($this->info['teams']))
        {
            // no teams
            return null;
        }
        $team = $this->info['teams'];
        if (isset($team[$teamId]))
        {
            return $team[$teamId];
        }
        return null;
    }
}
