<?php
namespace LeagueWrap\Response;

class MasteryPage extends Dto {

	/**
	 * Attempts to get a talent by its id.
	 *
	 * @param int $id
	 * @return Talent|null
	 */
	public function talent($id)
	{
		if ( ! isset($this->info['talents']))
		{
			// no talents
			return null;
		}
		$talents = $this->info['talents'];
		if (isset($talents[$id]))
		{
			return $talents[$id];
		}
		return null;
		
	}
}
