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
     * {@inheritdoc}
     */
    public function offsetSet($key, $value)
    {
        if (gettype($value) === 'string') {
            $value = new Header($key, $value);
        } elseif (! $value instanceof Header) {
            throw new InvalidArgumentException(
                "Header must implement \Koine\Http\Header"
            );
        }

        parent::offsetSet($key, $value);
    }
}
