<?php

namespace LeagueWrap\Api;


class MatchHistory extends AbstractApi {

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
     * Get the match history by summoner id.
     *
     * @param mixed $id
     * @return array
     */
    public function recent($identity)
    {
        $id = $this->extractId($identity);

        $array = $this->request('matchhistory/'.$id);
        $matchhistory = new \Leaguewrap\Dto\MatchHistory($array);

        $this->attachResponse($identity, $matchhistory, 'matchhistory');

        return $matchhistory;
    }

} 