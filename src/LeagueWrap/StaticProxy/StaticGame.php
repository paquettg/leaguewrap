<?php
namespace LeagueWrap\StaticProxy;

use Api;
use LeagueWrap\Api\Game;

class StaticGame extends AbstractStaticProxy {

	/**
	 * The game api class to be used for all requests.
	 *
	 * @var LeagueWrap\Api\Game
	 */
	protected static $game = null;

	public static function __callStatic($method, $arguments)
	{
		if (self::$game instanceof Game)
		{
			return call_user_func_array([self::$game, $method], $arguments);
		}
		else
		{
			self::$game = Api::game();
			return call_user_func_array([self::$game, $method], $arguments);
		}
	}

	/**
	 * Set the game api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$game = null;
	}
	
}

