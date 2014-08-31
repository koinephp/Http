<?php

namespace Koine\Http;

use Koine\Hash;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Headers extends Hash
{
    /**
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
            // TODO: throw exception
        }

        $this->sent = true;

        foreach ($this as $header => $value) {
            header("$header: $value");
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
        foreach ($this as $key  => $value) {
            $this->offsetUnset($key);
        }

        return $this;
    }
}
