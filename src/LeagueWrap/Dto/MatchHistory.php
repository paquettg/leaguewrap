<?php

namespace LeagueWrap\Dto;


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
     * @param int $id
     * @return Match|null
     */
    public function match($id)
    {
        if ( ! isset($this->info['matches'][$id]))
        {
            return null;
        }

        return $this->info['matches'][$id];
    }
} 