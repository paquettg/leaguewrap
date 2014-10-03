<?php
namespace LeagueWrap\StaticProxy;

abstract class AbstractStaticProxy {

	/**
	 * Mount this class as an alias.
	 *
	 * @param string $className
	 * @return void
	 */
	public static function mount($className = null)
	{
		if (is_null($className))
		{
			$class      = get_called_class();
			$namespaces = explode('\\', $class);
			$staticName = end($namespaces);
			$className  = preg_replace('/^Static/', '', $staticName);
		}
		if (class_exists($className))
		{
			return;
		}
		class_alias($class, $className);
	}

	/**
	 * Forces the current instance of the static proxy to be removed.
	 *
	 * @return void
	 */
	public static function fresh() {}

}
