<?php

namespace Koine\Http;

use Koine\Hash;
use Koine\Object;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Request extends Object
{
    protected $environment;

    public function __construct(array $options = array())
    {
        $options = new Hash($options);

        foreach ($options as $option => $value) {
            $this->send('set' . ucfirst($option), $value);
        }
    }

    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;

        return $this;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;

        return $this;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function setCookies(Cookies $cookies)
    {
        $this->cookies = $cookies;

        return $this;
    }
    public function getCookies()
    {
        return $this->cookies;
    }
}
