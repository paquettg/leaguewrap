<?php
namespace LeagueWrap\Dto;

use Countable;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use LeagueWrap\Exception\ListKeyNotSetException;

Abstract class AbstractListDto extends AbstractDto implements ArrayAccess, IteratorAggregate, Countable {

	protected $listKey = null;

	public function offsetExists($offset)
	{
		$info = $this->getListByKey();
		
		return isset($info[$offset]);
	}

	public function offsetGet($offset)
	{
		$info = $this->getListByKey();
		if ( ! isset($info[$offset]))
		{
			return null;
		}

		return $info[$offset];
	}

	public function offsetSet($offset, $value)
	{
		// just to make sure the listKey exists
		$this->getListByKey();
		if (is_null($offset))
		{
			$this->info[$this->listKey][] = $value;
		}
		else
		{
			$this->info[$this->listKey][$offset] = $value;
		}
	}

	public function offsetUnset($offset)
	{
		$this->getListByKey();
		unset($this->info[$this->listKey][$offset]);
	}

	public function getIterator()
	{
		return new ArrayIterator($this->getListByKey());
	}

	public function count()
	{
		return count($this->getListByKey());
	}

	protected function getListByKey()
	{
		if (is_null($this->listKey) or
		     ! isset($this->info[$this->listKey]))
		{
			throw new ListKeyNotSetException('The listKey is not found in the abstract list DTO');
		}

		return $this->info[$this->listKey];
	}
}
