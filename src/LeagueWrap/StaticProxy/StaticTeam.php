<?php
namespace LeagueWrap\StaticProxy;

use Api;
use LeagueWrap\Api\Team;

class StaticTeam extends AbstractStaticProxy {

	/**
	 * The team api class to be used for all requests.
	 *
	 * @var LeagueWrap\Api\Team
	 */
	protected static $team = null;

	public static function __callStatic($method, $arguments)
	{
		if (self::$team instanceof Team)
		{
			return call_user_func_array([self::$team, $method], $arguments);
		}
		else
		{
			self::$team = Api::team();
			return call_user_func_array([self::$team, $method], $arguments);
		}
	}
	
	/**
	 * Set the team api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$team = null;
	}
	
}


