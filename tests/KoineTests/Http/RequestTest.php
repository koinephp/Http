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
    protected $params;
    protected $getParam;
    protected $postParams;

    public function setUp()
    {
        $this->environment = new Environment(array());

        $session = array();
        $this->session = new Session($session);

        $cookies = array();
        $this->cookies = new Cookies($session);

        $this->params = new Params();
        $this->post   = new Params();
        $this->get    = new Params();

        $this->object = new Request(array(
            'environment' => $this->environment,
            'session'     => $this->session,
            'cookies'     => $this->cookies,
            'params'      => $this->params,
            'post'        => $this->post,
            'get'         => $this->get,
        ));
    }

    /**
     * @test
     */
    public function itCanSetEnvironmentViaConstructor()
    {
        $this->assertSame($this->environment, $this->object->getEnvironment());
    }

    /**
     * @test
     */
    public function itCanSetSessioinViaConstructor()
    {
        $this->assertSame($this->session, $this->object->getSession());
    }

    /**
     * @test
     */
    public function itCanGetTheCookies()
    {
        $this->assertSame($this->cookies, $this->object->getCookies());
    }

    /**
     * @test
     */
    public function setsParamsInTheConstructor()
    {
        $this->assertSame($this->params, $this->object->getParams());
    }

    /**
     * @test
     */
    public function setsPostParamsInTheConstructor()
    {
        $this->assertSame($this->post, $this->object->getPost());
    }

    /**
     * @test
     */
    public function setsGetParamsInTheConstructor()
    {
        $this->assertSame($this->get, $this->object->getGet());
    }
}
