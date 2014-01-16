<?php
namespace LeagueWrap\Facade;

abstract class Facade {

	/**
	 * Mount this class as an alias.
	 *
	 * @param string $className
	 * @return void
	 */
	public static function mount()
	{
		$class     = get_called_class();
		$className = end(explode('\\', $class));
		if (class_exists($className))
		{
			return;
		}
		class_alias($class, $className);
	}

	/**
	 * Forces the current instance of the facade to be removed.
	 *
	 * @return void
	 */
	abstract public static function fresh();

}
