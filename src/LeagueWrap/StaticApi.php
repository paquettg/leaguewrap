<?php
namespace Leaguewrap;

final class StaticApi {

	/**
	 * A list of all knowne facades to be found.
	 *
	 * @var array
	 */
	protected static $facades = [
		'Api',
		'Champion',
		'Game',
		'League',
		'Stats',
		'Summoner',
		'Team',
	];

	/**
	 * Mount all the static facades found in the Facade directory.
	 *
	 * @return void
	 */
	public static function mount()
	{
		foreach (self::$facades as $facade)
		{
			$facade = '\\LeagueWrap\\Facade\\Static'.$facade;
			// mount it
			$facade::mount();
			// freshen it up
			$facade::fresh();
		}
	}
}
