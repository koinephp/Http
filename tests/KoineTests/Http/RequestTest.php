<?php

namespace KoineTests\Http;

use Koine\Http\Request;
use Koine\Http\Environment;
use Koine\Http\Session;
use Koine\Http\Cookies;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class RequestTest extends PHPUnit_Framework_TestCase
{
    protected $environment;
    protected $object;
    protected $session;

    public function setUp()
    {
        $this->environment = new Environment(array());

        $session = array();
        $this->session = new Session($session);

        $cookies = array();
        $this->cookies = new Cookies($session);

        $this->object = new Request(array(
            'environment' => $this->environment,
            'session'     => $this->session,
            'cookies'     => $this->cookies,
        ));
    }

    /**
     * @test
     */
    public function itCanGetTheEnvironment()
    {
        $env = $this->object->getEnvironment();
        $this->assertInstanceOf('Koine\Http\Environment', $env);
        $this->assertSame($this->environment, $env);
    }

    /**
     * @test
     */
    public function itCanGetTheSession()
    {
        $session = $this->object->getSession();
        $this->assertInstanceOf('Koine\Http\Session', $session);
        $this->assertSame($this->session, $session);
    }

    /**
     * @test
     */
    public function itCanGetTheCookies()
    {
        $cookies = $this->object->getCookies();
        $this->assertInstanceOf('Koine\Http\Cookies', $cookies);
        $this->assertSame($this->cookies, $cookies);
    }
}
