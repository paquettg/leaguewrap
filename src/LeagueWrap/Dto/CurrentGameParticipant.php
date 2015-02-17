<?php
namespace LeagueWrap\Dto;

/**
 * participant of a current game
 * @package LeagueWrap\Dto
 */
class CurrentGameParticipant extends AbstractDto {
    use ImportStaticTrait;

    protected $staticFields = [
        'championId' => 'champion',
        'spell1Id'   => 'summonerSpell',
        'spell2Id'   => 'summonerSpell',
    ];

    /**
     * Set up the information about this Participant.
     *
     * @param array $info
     */
    public function __construct(array $info)
    {
        // player masteries
        if(isset($info['masteries']))
        {
            $rawMasteries = $info['masteries'];
            $masteries = [];
            foreach($rawMasteries as $m)
            {
                $mastery = new Mastery($m);
                $masteries[$mastery->masteryId] = $mastery;
            }
            $info['masteries'] = $masteries;
        }

        // player runes
        if(isset($info['runes']))
        {
            $rawRunes = $info['runes'];
            $runes = [];
            foreach($rawRunes as $r)
            {
                $rune = new Rune($r);
                $runes[$rune->runeId] = $rune;
            }
            $info['runes'] = $runes;
        }

        parent::__construct($info);
    }

    /**
     * @param $masteryId
     * @return null || \Leaguewrap\Dto\Mastery
     */
    public function mastery($masteryId)
    {
        if(!isset($this->info['masteries']))
        {
            return null;
        }

        $masteries = $this->masteries;
        if(!isset($masteries[$masteryId]))
        {
            return null;
        }
        return $masteries[$masteryId];
    }

    /**
     * @param $runeId
     * @return null || \Leaguewrap\Dto\Rune
     */
    public function rune($runeId)
    {
        if(!isset($this->info['runes']))
        {
            return null;
        }

        $runes = $this->runes;
        if(!isset($runes[$runeId]))
        {
            return null;
        }
        return $runes[$runeId];
    }
}
