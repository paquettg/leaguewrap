<?php


namespace LeagueWrap\Api;


class Matchlist extends AbstractApi {

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
     * Get the match list by summoner identity.
     * @param $identity int|Summoner
     * @param array|string|null $rankedQueues List of ranked queue types to use for fetching games.
     * @param array|string|null $seasons List of seasons to use for fetching games.
     * @param array|string|null $championIds Comma-separated list of champion IDs to use for fetching games.
     * @param int|null $beginIndex The begin index to use for fetching games.
     * @param int|null $endIndex The end index to use for fetching games.
     * @param int|null $beginTime The begin time for fetching games in milliseconds
     * @param int|null $endTime The end time for fetching games in milliseconds
     * @return \LeagueWrap\Dto\MatchHistory
     * @throws \LeagueWrap\Exception\CacheNotFoundException
     * @throws \LeagueWrap\Exception\InvalidIdentityException
     * @throws \LeagueWrap\Exception\RegionException
     */
    public function matchlist($identity, $rankedQueues = null, $seasons = null, $championIds = null, $beginIndex = null, $endIndex = null, $beginTime = null, $endTime = null)
    {
        $summonerId = $this->extractId($identity);

        $requestParamas = $this->parseParams($rankedQueues, $seasons, $championIds, $beginIndex, $endIndex, $beginTime, $endTime);
        $array          = $this->request('matchlist/by-summoner/'.$summonerId, $requestParamas);
        $matchList   = $this->attachStaticDataToDto(new \LeagueWrap\Dto\MatchList($array));

        $this->attachResponse($identity, $matchList, 'matchlist');

        return $matchList;
    }

    protected function parseParams($rankedQueues = null, $seasons = null, $championIds = null, $beginIndex = null, $endIndex = null, $beginTime = null, $endTime = null)
    {
        $params = [];

        if(isset($rankedQueues))
        {
            if(is_array($rankedQueues))
            {
                $params['rankedQueues'] = implode(',', $rankedQueues);
            }
            else
            {
                $params['rankedQueues'] = $rankedQueues;
            }
        }
        if(isset($seasons))
        {
            if(is_array($seasons))
            {
                $params['seasons'] = implode(',', $seasons);
            }
            else
            {
                $params['seasons'] = $seasons;
            }
        }

        if(isset($championIds))
        {
            if(is_array($championIds))
            {
                $params['championIds'] = implode(',', $championIds);
            }
            else
            {
                $params['championIds'] = $championIds;
            }
        }

        if(isset($beginIndex))
        {
            $params['beginIndex'] = $beginIndex;
        }
        if(isset($endIndex))
        {
            $params['endIndex'] = $endIndex;
        }
        if(isset($beginTime))
        {
            $params['beginTime'] = $beginTime;
        }
        if(isset($endTime))
        {
            $params['endTime'] = $endTime;
        }

        return $params;
    }

}