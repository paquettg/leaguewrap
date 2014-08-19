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
        $identitz = $this->info['participantIdentities'];
        if (isset($identitz[$id]))
        {
            return $identitz[$id];
        }
        return null;
    }
} 