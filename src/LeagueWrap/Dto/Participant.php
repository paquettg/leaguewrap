<?php

namespace LeagueWrap\Dto;


class Participant extends AbstractDto {

    /**
     * Set up the information about this Participant.
     *
     * @param array $info
     */
    public function __construct(array $info)
    {
        // player stats
        if(isset($info['stats']))
            $info['stats'] = new Stats($info['stats']);

        // timeline - this is optional for matches api
        if(isset($info['timeline']))
            $info['timeline'] = new ParticipantTimeline($info['timeline']);


        parent::__construct($info);
    }

}