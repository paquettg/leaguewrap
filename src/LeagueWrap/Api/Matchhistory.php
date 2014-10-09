<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\MatchHistory as MatchHistoryDto;

class Matchhistory extends AbstractApi {

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
     * Get the match history by summoner identity.
     * @param $identity int|Summoner
     * @param array|string|null $rankedQueues List of ranked queue types to use for fetching games.
     * @param array|string|null $championIds Comma-separated list of champion IDs to use for fetching games.
     * @param int|null $beginIndex The begin index to use for fetching games.
     * @param int|null $endIndex The end index to use for fetching games.
     * @return \LeagueWrap\Dto\MatchHistory
     * @throws \LeagueWrap\Exception\CacheNotFoundException
     * @throws \LeagueWrap\Exception\InvalidIdentityException
     * @throws \LeagueWrap\Exception\RegionException
     */
    public function history($identity, $rankedQueues = null, $championIds = null, $beginIndex = null, $endIndex = null)
    {
        $matchId = $this->extractId($identity);

        $requestParamas = $this->parseParams($rankedQueues, $championIds, $beginIndex, $endIndex);
        $array          = $this->request('matchhistory/'.$matchId, $requestParamas);
        $matchhistory   = $this->attachStaticDataToDto(new MatchHistoryDto($array));

        $this->attachResponse($identity, $matchhistory, 'matchhistory');

        return $matchhistory;
    }

    protected function parseParams($rankedQueues = null, $championIds = null, $beginIndex = null, $endIndex = null)
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

        return $params;
    }

} 
