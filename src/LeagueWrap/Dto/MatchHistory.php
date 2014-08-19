<?php

namespace LeagueWrap\Dto;


class MatchHistory extends AbstractListDto {

    protected $listKey = 'matches';

    public function __construct(array $info)
    {
        if (isset($info['matches']))
        {
            $matches = [];
            foreach ($info['matches'] as $match)
            {
                $match = new Match($match);
                $matches[$match->matchId] = $match;

            }
            $info['matches'] = $matches;
        }

        parent::__construct($info);
    }
} 