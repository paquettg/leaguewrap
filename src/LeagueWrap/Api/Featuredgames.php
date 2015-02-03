<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\FeaturedGames as FeaturedGamesDto;

class Featuredgames extends AbstractApi
{

	/**
	 * Valid versions for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.0',
	];

	/**
	 * A list of all permitted regions for the Champion api call.
	 *
	 * @param array
	 */
	protected $permittedRegions = [
		'br',
		'eune',
		'euw',
		'lan',
		'las',
		'na',
		'oce',
		'ru',
		'tr',
		'kr',
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 900;

	public function featuredGames()
	{
		$response = $this->request('featured', [], false, true);

		return $this->attachStaticDataToDto(new FeaturedGamesDto($response));
	}
}
