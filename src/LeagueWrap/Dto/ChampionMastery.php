<?php

namespace LeagueWrap\Dto;


class ChampionMastery extends AbstractDto
{
    use ImportStaticTrait;

    protected $staticFields = [
        'championId' => 'champion',
    ];

}