<?php

namespace LeagueWrap\Api;

class Match extends AbstractApi
{
    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [
        'v2.2',
    ];

    /**
     * A list of all permitted regions for the Champion api call.
     *
     * @param array
     */
    protected $permittedRegions = [
        'br',
        'eune',
        'euw',
        'lan',
        'las',
        'na',
        'oce',
        'kr',
        'ru',
        'tr',
    ];

    /**
     * The amount of time we intend to remember the response for.
     *
     * @var int
     */
    protected $defaultRemember = 1800;

    /**
     * Get the match by match id.
     *
     * @param int $matchId
     * @param bool $includeTimeline
     * @return Match
     */
    public function match($matchId, $includeTimeline = false)
    {
        if($includeTimeline)
            $response = $this->request('match/'.$matchId, array('includeTimeline' => $includeTimeline));
        else
            $response = $this->request('match/'.$matchId);
        return new \LeagueWrap\Dto\Match($response);
    }
} 
