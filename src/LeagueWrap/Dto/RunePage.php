<?php
namespace LeagueWrap\Dto;

class RunePage extends AbstractListDto {

	protected $listKey = 'runes';

	/**
	 * Attempts to get a rune by slot id.
	 *
	 * @param int $runeId
	 * @return Rune|null
	 */
	public function rune($runeId)
	{
		if ( ! isset($this->info['runes']))
		{
			// no runes
			return null;
		}
		$runes = $this->info['runes'];
		if (isset($runes[$runeId]))
		{
			return $runes[$runeId];
		}
		return null;
	}
}
