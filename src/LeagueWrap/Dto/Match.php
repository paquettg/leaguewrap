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
        foreach ($rawParticipants as $rawParticipant)
        {
            $participant                               = new Participant($rawParticipant);
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
        foreach ($rawrParticipantIds as $rawParticipantID)
        {
            $identity                                 = new ParticipantIdentity($rawParticipantID);
            $participantIds[$identity->participantId] = $identity;
        }
        $info['participantIdentities'] = $participantIds;

        // set teams (only for match api)
        if( ! isset($info['teams']))
        {
			// no teams
			$info['teams'] = [];
		}
        $rawTeams = $info['teams'];
        $teams    = [];
        foreach($rawTeams as $key => $rawTeam)
        {
			$match       = new MatchTeam($rawTeam);
            $teams[$key] = $match;
        }
        $info['teams'] = $teams;

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
        $team = $this->info['teams'];
        if (isset($team[$teamId]))
        {
            return $team[$teamId];
        }
        return null;
    }
}
