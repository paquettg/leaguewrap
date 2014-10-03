<?php
namespace LeagueWrap\StaticProxy;

use Api;
use LeagueWrap\Api\Summoner;

class StaticSummoner extends AbstractStaticProxy {

	/**
	 * The summoner api class to be used for all requests.
	 *
	 * @var LeagueWrap\Api\Summoner
	 */
	protected static $summoner = null;

	public static function __callStatic($method, $arguments)
	{
		if (self::$summoner instanceof Summoner)
		{
			return call_user_func_array([self::$summoner, $method], $arguments);
		}
		else
		{
			self::$summoner = Api::summoner();
			return call_user_func_array([self::$summoner, $method], $arguments);
		}
	}
	
	/**
	 * Set the summoner api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$summoner = null;
	}
	
}
