<?php
namespace LeagueWrap\Response;

class RunePage extends Dto {

	/**
	 * Attempts to get a rune by slot id.
	 *
	 * @param int $id
	 * @return Rune|null
	 */
	public function rune($id)
	{
		if ( ! isset($this->info['runes']))
		{
			// no runes
			return null;
		}
		$runes = $this->info['runes'];
		if (isset($runes[$id]))
		{
			return $runes[$id];
		}
		return null;
	}
}
