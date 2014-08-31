<?php

namespace Koine\Http;

use Koine\Hash;
use Koine\Object;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class Request extends Object
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Cookies
     */
    protected $cookies;

    /**
     * Valid options:
     *      environment - The Environment
     *      session - The Session
     *      cookies - The Cookies
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $options = new Hash($options);

        foreach ($options as $option => $value) {
            $this->send('set' . ucfirst($option), $value);
        }
    }

    /**
     * @param  Environment $environment
     * @return self
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     * Get the environment
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param  Session $session
     * @return self
     */
    public function setSession(Session $session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get the session
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param  Cookies $cookies
     * @return self
     */
    public function setCookies(Cookies $cookies)
    {
        $this->cookies = $cookies;

        return $this;
    }

    /**
     * Get the cookies
     * @return Cookies
     */
    public function getCookies()
    {
        return $this->cookies;
    }
}
