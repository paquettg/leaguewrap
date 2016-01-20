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
     * @param array @platformIds platform ids for regions
     */
    protected $platformIds = [
        'na'   => 'NA1',
        'euw'  => 'EUW1',
        'br'   => 'BR1',
        'lan'  => 'LA1',
        'las'  => 'LA2',
        'oce'  => 'OC1',
        'eune' => 'EUN1',
        'tr'   => 'TR1',
        'ru'   => 'RU',
        'kr'   => 'KR'
    ];

    /**
     * Intercept client request to patch platform id into url (ugly hack!)
     *
     * @param bool $static
     * @param string $uri
     * @param array $params
     * @return string
     * @throws \LeagueWrap\Exception\LimitReachedException
     */
    protected function clientRequest($static, $uri, $params)
    {
        $uri = sprintf($uri, $this->platformIds[$this->region->getRegion()]);

        return parent::clientRequest($static, $uri, $params);
    }

    public function champions($identity) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('championmastery/location/'.'%1$s'.'/player/'.$summonerId.'/champions', [], false, false, true);

        $championMasteryList = new ChampionMasteryList($response);
        $this->attachResponse($identity, $championMasteryList, "championmastery");
        return $championMasteryList;
    }

    public function champion($identity, $championId) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('championmastery/location/'.'%1$s'.'/player/'.$summonerId.'/champion/'.$championId, [], false, false, true);

        $mastery = new \LeagueWrap\Dto\ChampionMastery($response);
        $this->attachResponse($identity, $mastery, "championmastery");
        return $mastery;
    }

    public function topChampions($identity, $count = 3) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('championmastery/location/'.'%1$s'.'/player/'.$summonerId.'/topchampions', ['count' => $count], false, false, true);

        $mastery = new \LeagueWrap\Dto\ChampionMasteryList($response);
        $this->attachResponse($identity, $mastery, "championmastery");
        return $mastery;
    }

    public function score($identity) {
        $summonerId = $this->extractId($identity);
        $response = $this->request('championmastery/location/'.'%1$s'.'/player/'.$summonerId.'/score', [], false, false, true);

        $score = intval($response);
        $this->attachResponse($identity, $score, "score");
        return intval($response);
    }



}
