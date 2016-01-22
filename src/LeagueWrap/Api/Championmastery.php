<?php

namespace LeagueWrap\Api;


use LeagueWrap\Dto\ChampionMasteryList;

class ChampionMastery extends AbstractApi
{

    /**
     * Valid version for this api call.
     *
     * @var array
     */
    protected $versions = [];

    /**
     * A list of all permitted regions for the league api call.
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
        'ru',
        'tr',
        'kr',
    ];

    /**
     * The amount of time we intend to remember the response for.
     *
     * @var int
     */
    protected $defaultRemember = 900;

    /**
     * @return String domain used for the request
     */
    function getDomain()
    {
        return $this->getRegion()->getChampionMasteryDomain();
    }

    public function champions($identity) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('player/'.$summonerId.'/champions', [], false, false);

        $championMasteryList = new ChampionMasteryList($response);
        $this->attachResponse($identity, $championMasteryList, "championmastery");
        return $championMasteryList;
    }

    public function champion($identity, $championId) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('player/'.$summonerId.'/champion/'.$championId, [], false, false);

        $mastery = new \LeagueWrap\Dto\ChampionMastery($response);
        $this->attachResponse($identity, $mastery, "championmastery");
        return $mastery;
    }

    public function topChampions($identity, $count = 3) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('player/'.$summonerId.'/topchampions', ['count' => $count], false, false);

        $mastery = new \LeagueWrap\Dto\ChampionMasteryList($response);
        $this->attachResponse($identity, $mastery, "championmastery");
        return $mastery;
    }

    public function score($identity) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('player/'.$summonerId.'/score', [], false, false);

        $score = intval($response);
        $this->attachResponse($identity, $score, "score");
        return intval($response);
    }



}
