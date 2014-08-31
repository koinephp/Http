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

    public function __construct(array $options = array())
    {
        $options = new Hash($options);

        $this->setHeaders($options->fetch('headers', function () {
            return new Headers();
        }));

        $this->body = new String();
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders(Headers $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function getBody()
    {
        return $this->body->toString();
    }

    public function setBody($body)
    {
        $this->body = new String((string) $body);

        return $this;
    }

    public function appendBody($content)
    {
        $this->body->append($content);

        return $this;
    }

    public function prependBody($content)
    {
        // TODO: Create prepend method to the String class
        return $this->setBody($content . $this->getBody());
    }

    public function send()
    {
        $this->getHeaders()->send();
        echo $this->getBody();
    }
}
