<?php

namespace Koine\Http;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Header
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var boolean
     */
    protected $override = true;

    /**
     * @var integer
     */
    protected $statusCode;

    /**
     * @param string  $name       the name of the header
     * @param string  $value      the value of the header
     * @param boolean $override   if the header should be overriden
     * @param integer $statusCode the response status code
     */
    public function __construct($name, $value = null, $override = true, $statusCode = null)
    {
        $this->name       = $name;
        $this->value      = $value;
        $this->override   = $override;
        $this->statusCode = (int) $statusCode;
    }

    /**
     * Converts header to string
     * @return string
     */
    public function __toString()
    {
        $string = $this->name;

        if ($this->value !== null) {
            $string .= ': ' . $this->value;
        }

        return $string;
    }

    /**
     * Send headers
     */
    public function send()
    {
        $string = (string) $this;

        if ($this->statusCode) {
            header($string, $this->override, $this->statusCode);
        } else {
            header($string, $this->override);
        }
    }
}
