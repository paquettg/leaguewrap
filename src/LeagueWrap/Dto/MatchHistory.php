<?php

namespace LeagueWrap\Dto;

/**
 * Class MatchHistory
 * @package LeagueWrap\Dto
 * Whole match history of a summoner
 */
class MatchHistory extends AbstractListDto {

    protected $listKey = 'matches';

    public function __construct(array $info)
    {
        if (isset($info['matches']))
        {
            $matches = [];
            foreach ($info['matches'] as $key => $value)
            {
                $matches[$key] = new Match($value);
            }
            $info['matches'] = $matches;
        }

        parent::__construct($info);
    }

    /**
     * Get a match by the id.
     *
     * @param int $martchId
     * @return Match|null
     */
    public function match($martchId)
    {
        if ( ! isset($this->info['matches'][$martchId]))
        {
            return null;
        }

        return $this->info['matches'][$martchId];
    }
} 
