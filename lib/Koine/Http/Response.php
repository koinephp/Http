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
}
