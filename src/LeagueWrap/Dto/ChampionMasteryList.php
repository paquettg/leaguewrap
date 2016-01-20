<?php
/**
 * Created by PhpStorm.
 * User: danijoo
 * Date: 1/20/2016
 * Time: 12:45 PM
 */

namespace LeagueWrap\Dto;


class ChampionMasteryList extends AbstractListDto
{

    protected $listKey = '';

    /**
     * @param array $info
     */
    public function __construct(array $info)
    {
        foreach($info as &$mastery) {
            $mastery = new ChampionMastery($mastery);
        }
        parent::__construct($info);
    }

    /**
     * Get a champion by its id.
     *
     * @param int $championId
     * @return ChampionMastery|null
     */
    public function getChampion($championId)
    {
        foreach($this->info as $mastery) {
            if($mastery->championId == $championId)
                return $mastery;
        }
        return null;
    }

}