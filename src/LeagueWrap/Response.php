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
	 * Request's headers.
	 *
	 * @var array
	 */
	protected $headers;

	/**
	 * The primary content of the response.
	 *
	 * @param string 			$content
	 * @param int    			$code
	 * @param array|string[][]	$headers
	 */
	public function __construct($content, $code, array $headers = [])
	{
		$this->content = trim($content);
		$this->code    = intval($code);
		$this->headers = [];
		foreach($headers as $name => $values) {
			$this->headers[$name] = $values[0];
		}
	}

	/**
	 * Returns the content of the response as a string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->content;
	}

	/**
	 * Returns the code associated with the response.
	 *
	 * @return int
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Return array of header from response in format
	 * header key => header value.
	 * Only one value per header key is allowed.
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * Check if header key is present
	 *
	 * @param string $name
	 * @return bool
	 */
	public function hasHeader($name)
	{
		return array_key_exists($name, $this->headers);
	}

	/**
	 * Return header's value by key.
	 * If the header is not present, return null.
	 *
	 * @param string $name
	 * @return string|null
	 */
	public function getHeader($name)
	{
		return $this->hasHeader($name) ? $this->headers[$name] : null;
	}
}
