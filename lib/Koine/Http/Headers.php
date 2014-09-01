<?php

namespace Koine\Http;

use Koine\Hash;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Headers extends Hash
{
    /**
     * Were the headers sent?
     * @var boolean
     */
    protected $sent = false;

    /**
     * The request status code
     * @var integer
     */
    protected $statusCode = 200;

    /**
     * @var array HTTP response codes and messages
     */
    protected $validStatusCodes = array(
        //Informational 1xx
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        //Successful 2xx
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        //Redirection 3xx
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',
        //Client Error 4xx
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        418 => '418 I\'m a teapot',
        422 => '422 Unprocessable Entity',
        423 => '423 Locked',
        //Server Error 5xx
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported'
    );

    /**
     * Checks if the headers have been sent
     * @return boolean
     */
    public function sent()
    {
        return $this->sent;
    }

    /**
     * Send the headers
     * @return self
     */
    public function send()
    {
        if ($this->sent()) {
            throw new Exceptions\HeadersAlreadySentException(
                "Headers already sent"
            );
        }

        $this->sent = true;

        foreach ($this as $header) {
            $header->send();
        }

        return $this;
    }

    /**
     * Set the location to redirect to
     *
     * @param  string $contentType
     * @return self
     */
    public function setLocation($location)
    {
        $this['Location'] = $location;

        return $this;
    }

    /**
     * Set the content type
     *
     * @param  string $contentType
     * @return self
     */
    public function setContentType($contentType)
    {
        $this['Content-Type'] = $contentType;

        return $this;
    }

    /**
     * Clear header
     * @return self
     */
    public function clear()
    {
        foreach ($this as $key => $value) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * Sets the status code
     * @param  integer $status
     * @return self
     */
    public function setStatusCode($code)
    {
        $code = (int) $code;

        if (!array_key_exists($code, $this->validStatusCodes)) {
            throw new Exceptions\InvalidStatusCodeException(
                "'$code' is an invalid status code"
            );
        }

        $this->statusCode = $code;

        return $this;
    }

    /**
     * Get the response status code
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value)
    {
        if (gettype($value) === 'string') {
            $value = new Header($key, $value);
        } else if (! $value instanceof Header) {
            throw new InvalidArgumentException(
                "Header must implement \Koine\Http\Header"
            );
        }

        parent::offsetSet($key, $value);
    }
}
