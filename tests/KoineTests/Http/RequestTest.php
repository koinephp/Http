<?php

namespace KoineTests\Http;

use Koine\Http\Request;
use Koine\Http\Environment;
use Koine\Http\Session;
use Koine\Http\Cookies;
use Koine\Http\Params;
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
    public function itCanSetEnvironmentViaConstructor()
    {
        $env    = new Environment(array());
        $object = new Request(array('environment' => $env));

        $this->assertSame($env, $object->getEnvironment());
    }

    /**
     * @test
     */
    public function itCanSetSessioinViaConstructor()
    {
        $session = array();
        $session = new Session($session);
        $object  = new Request(array('session' => $session));

        $this->assertSame($session, $object->getSession());
    }

    /**
     * @test
     */
    public function itCanGetTheCookies()
    {
        $cookies = array();
        $cookies = new Cookies($cookies);
        $object  = new Request(array('cookies' => $cookies));

        $this->assertSame($cookies, $object->getCookies());
    }

    /**
     * @test
     */
    public function setsParamsInTheConstructor()
    {
        $params = new Params(array());
        $object = new Request(array('params' => $params));

        $this->assertSame($params, $object->getParams());
    }

    /**
     * @test
     */
    public function setsPostParamsInTheConstructor()
    {
        $params = new Params(array());
        $object = new Request(array('post' => $params));

        $this->assertSame($params, $object->getPost());
    }

    /**
     * @test
     */
    public function setsGetParamsInTheConstructor()
    {
        $params = new Params(array());
        $object = new Request(array('get' => $params));

        $this->assertSame($params, $object->getGet());
    }
}
