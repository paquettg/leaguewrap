<?php
namespace LeagueWrap\Response;

use Exception;
use LeagueWrap\Exception\NoResponseIncludedException;
use LeagueWrap\Response;

abstract class ResponseException extends Exception {
    /**
     * Response that caused this exception.
     *
     * @var Response
     */
    protected $response;

    /**
     * Static constructor for including response.
     *
     * @param string   $message
     * @param Response $response
     *
     * @return static
     */
    public static function withResponse($message, Response $response)
    {
        $e = new static();
        $e->response = $response;
        $e->message = $message;

        return $e;
    }

    /**
     * Check if response was provided.
     *
     * @return bool
     */
    public function hasResponse()
    {
        return !!$this->response;
    }

    /**
     * Access the response.
     *
     * @throws NoResponseIncludedException
     * @return Response
     */
    public function getResponse()
    {
        if (!$this->response) {
            throw new NoResponseIncludedException(
                'No response information was provided. '.
                'Use hasResponse() to check if this exception has response attached.'
            );
        }
        
        return $this->response;
    }
}
