<?php
namespace LeagueWrap\StaticProxy;

use Api;
use LeagueWrap\Api\Stats;

class StaticStats extends AbstractStaticProxy {

	/**
	 * The Stats api class to be used for all requests.
	 *
	 * @var LeagueWrap\Api\Stats
	 */
	protected static $stats = null;

	public static function __callStatic($method, $arguments)
	{
		if (self::$stats instanceof Stats)
		{
			return call_user_func_array([self::$stats, $method], $arguments);
		}
		else
		{
			self::$stats = Api::stats();
			return call_user_func_array([self::$stats, $method], $arguments);
		}
	}

	/**
	 * Set the stats api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$stats = null;
	}
	
}

