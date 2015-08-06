<?php

namespace LeagueWrap\Dto;

/**
 * Class MatchList
 * A matchlist is a list of matches with condensed information
 * @see \Leaguewrap\Dto\MatchListMatch
 * @package LeagueWrap\Dto
 * Matchlist of a summoner
 */
class MatchList extends AbstractListDto {

    protected $listKey = 'matches';

    public function __construct(array $info)
    {
        if (isset($info['matches']))
        {
            $matches = [];
            foreach ($info['matches'] as $key => $value)
            {
                $match = new MatchReference($value);
                $matches[$key] = $match;
            }
            $info['matches'] = $matches;
        }
        else
        {
            $info['matches'] = array();
        }

        parent::__construct($info);
    }

    /**
     * Get a match by position.
     *
     * @param int $matchPosition
     * @return Match|null
     */
    public function match($matchPosition)
    {
        if ( ! isset($this->info['matches'][$matchPosition]))
        {
            return null;
        }

        return $this->info['matches'][$matchPosition];
    }

}