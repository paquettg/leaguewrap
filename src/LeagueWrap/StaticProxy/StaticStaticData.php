<?php
namespace LeagueWrap\StaticProxy;

use Api;
use LeagueWrap\Api\Staticdata;

class StaticStaticData extends AbstractStaticProxy {

	/**
	 * The static data api class to be used for all requests.
	 *
	 * @var LeagueWrap\Api\Staticdata
	 */
	protected static $staticData = null;

	public static function __callStatic($method, $arguments)
	{
		if (self::$staticData instanceof Staticdata)
		{
			return call_user_func_array([self::$staticData, $method], $arguments);
		}
		else
		{
			self::$staticData = Api::staticData();
			return call_user_func_array([self::$staticData, $method], $arguments);
		}
	}

	/**
	 * Set the static data api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$staticData = null;
	}
}
