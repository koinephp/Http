<?php

namespace Koine\Http;

use Koine\Hash;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Request
{
    protected $environment;

    public function __construct(array $options = array())
    {
        $options = new Hash($options);

        $this->setEnvironment($options->fetch('environment'));
        $this->setSession($options->fetch('session'));
        $this->setCookies($options->fetch('cookies'));
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
