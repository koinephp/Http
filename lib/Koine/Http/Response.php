<?php

namespace Koine\Http;

use Koine\Hash;
use Koine\String;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Response
{

    /**
     * @var Headers
     */
    protected $headers;

    /**
     * @var String
     */
    protected $body;

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
     * The available options are:
     *  - headers - the response headers
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $options = new Hash($options);

        $this->setHeaders($options->fetch('headers', function () {
            return new Headers();
        }));

        $this->body = new String();
    }

    /**
     * Get the response headers
     * @return Headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set the headers
     * @param  Headers $headers
     * @return self
     */
    public function setHeaders(Headers $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get the response content
     * @return string
     */
    public function getBody()
    {
        return $this->body->toString();
    }

    /**
     * Set the response content
     * @param  string $body
     * @return self
     */
    public function setBody($body)
    {
        $this->body = new String((string) $body);

        return $this;
    }

    /**
     * Append content to the response
     * @param  string $content
     * @return self
     */
    public function appendBody($content)
    {
        $this->body->append($content);

        return $this;
    }

    /**
     * Prepends content to the response
     * @param  string $content
     * @return self
     */
    public function prependBody($content)
    {
        // TODO: Create prepend method to the String class
        return $this->setBody($content . $this->getBody());
    }

    /**
     * Sends the response
     *  - Send headers
     *  - Echoes content
     */
    public function send()
    {
        $this->getHeaders()->send();
        echo $this->getBody();
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

}
