<?php
namespace LeagueWrap\Facade;

use LeagueWrap;

class League extends Facade {

	/**
	 * The League api class to be used for all requests.
	 *
	 * @var LeagueWrap\Api\League
	 */
	protected static $league = null;

	public static function __classStatic($method, $arguments)
	{
		if (self::$league instanceof LeagueWrap\Api\League)
		{
			return call_user_func_array([self::$league, $method], $arguments);
		}
		else
		{
			self::$league = Api::league();
			return call_user_func_array([self::$league, $method], $arguments);
		}
	}
	
	/**
	 * Set the league api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$league = null;
	}
	
}

