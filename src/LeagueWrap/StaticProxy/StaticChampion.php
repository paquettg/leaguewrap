<?php
namespace LeagueWrap\StaticProxy;

use Api;
use LeagueWrap\Api\Champion;

class StaticChampion extends AbstractStaticProxy {

	/**
	 * The champion api class to be used for all requests.
	 *
	 * @var \LeagueWrap\Api\Champion
	 */
	protected static $champion = null;

    /**
     * Magic method.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
	{
		if (self::$champion instanceof Champion)
		{
			return call_user_func_array([self::$champion, $method], $arguments);
		}
		else
		{
			self::$champion = Api::champion();
			return call_user_func_array([self::$champion, $method], $arguments);
		}
	}

	/**
	 * Set the champion api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$champion = null;
	}
	
}
