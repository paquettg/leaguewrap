<?php
namespace LeagueWrap\Facade;

use LeagueWrap\Api;
use LeagueWrap\ClientInterface;

final class StaticApi extends AbstractFacade {

	/**
	 * The api class to be used for all requests.
	 *
	 * @var LeagueWrap\Api
	 */
	protected static $api = null;

	public static function __callStatic($method, $arguments)
	{
		if (self::$api instanceof Api)
		{
			return call_user_func_array([self::$api, $method], $arguments);
		}
		else
		{
			throw new Exception('The api is not loaded. Please set the key using the setKey() static method.');
		}
	}

	/**
	 * Creates the Api and sets the key/client.
	 *
	 * @param string $key
	 * @param ClientInterface $client
	 * @chainable
	 */
	public static function setKey($key, ClientInterface $client = null)
	{
		self::$api = new Api($key, $client);
		return self::$api;
	}

	/**
	 * Set the api to null.
	 *
	 * @return void
	 */
	public static function fresh()
	{
		self::$api = null;
	}
}
