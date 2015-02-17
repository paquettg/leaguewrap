<?php
namespace LeagueWrap;

class Response {

	/**
	 * The content of the response.
	 * 
	 * @var string
	 */
	protected $content;

	/**
	 * The HTTP code resulting from the request.
	 *
	 * @var integer
	 */
	protected $code;

	/**
	 * The primary content of the response.
	 *
	 * @param string $content
	 */
	public function __construct($content)
	{
		$this->content = trim($content);
	}

	public function __toString()
	{
		return $this->content;
	}

	public function setCode($code)
	{
		$this->code = intval($code);
		return $this;
	}

	public function getCode()
	{
		return $this->code;
	}
}
