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
        $this->cookies = new Cookies($cookies);

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

    /**
     * @test
     */
    public function canVerifyIfRequestisAjax()
    {
        $this->assertFalse($this->object->isXhr());
        $this->assertFalse($this->object->isAjax());

        $this->environment['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';

        $this->assertTrue($this->object->isXhr());
        $this->assertTrue($this->object->isAjax());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsPost()
    {
        $this->environment['REQUEST_METHOD'] = 'GET';

        $this->assertFalse($this->object->isPost());

        $this->environment['REQUEST_METHOD'] = 'POST';

        $this->assertTrue($this->object->isPost());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsGet()
    {
        $this->environment['REQUEST_METHOD'] = 'GET';

        $this->assertTrue($this->object->isGet());

        $this->environment['REQUEST_METHOD'] = 'POST';

        $this->assertFalse($this->object->isGet());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsPatch()
    {
        $this->environment['REQUEST_METHOD'] = 'PATCH';

        $this->assertTrue($this->object->isPatch());

        $this->environment['REQUEST_METHOD'] = 'POST';

        $this->assertFalse($this->object->isPatch());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsPut()
    {
        $this->environment['REQUEST_METHOD'] = 'PUT';

        $this->assertTrue($this->object->isPut());

        $this->environment['REQUEST_METHOD'] = 'GET';

        $this->assertFalse($this->object->isPut());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsDelete()
    {
        $this->environment['REQUEST_METHOD'] = 'DELETE';

        $this->assertTrue($this->object->isDelete());

        $this->environment['REQUEST_METHOD'] = 'GET';

        $this->assertFalse($this->object->isDelete());
    }

    /**
     * @test
     */
    public function canVerifyRequestMethod()
    {
        $this->environment['REQUEST_METHOD'] = 'GET';

        $this->assertEquals('GET', $this->object->getMethod());

        $this->environment['REQUEST_METHOD'] = 'POST';

        $this->assertEquals('POST', $this->object->getMethod());
    }

    public function dataProviderForRequestMethods()
    {
        return array(
            array('POST', null, 'POST'),
            array('POST', 'PATCH', 'PATCH'),
        );
    }

    /**
     * @test
     * @dataProvider dataProviderForRequestMethods
     */
    public function itCanFakeRequestMethod($realMethod, $fakeMethod, $expectation)
    {
        $this->environment['REQUEST_METHOD'] = $realMethod;
        $this->params['_method']             = $fakeMethod;

        $this->assertEquals($expectation, $this->object->getMethod());
    }

    /**
     * @test
     * @expectedException Koine\Http\Exceptions\InvalidRequestMethodException
     * @expectedExceptionMessage 'patch' is not a valid request method
     */
    public function itThrowsExceptionWhenGivenMethodIsInvalid()
    {
        $this->params['_method'] = 'patch';
        $this->object->getMethod();
    }

    public function getConstructorArguments()
    {
        return array(
            array('environment'),
            array('session'),
            array('cookies'),
            array('params'),
        );
    }

    /**
     * @test
     * @dataProvider getConstructorArguments
     */
    public function constructorThrowsExceptionWhenArgumentIsNotPassed($key)
    {
        $this->setExpectedException(
            "InvalidArgumentException",
            "Parameter '$key' was not provided"
        );

        $arguments = array(
            'environment' => $this->environment,
            'session'     => $this->session,
            'cookies'     => $this->cookies,
            'params'      => $this->params,
        );

        unset($arguments[$key]);

        $this->object = new Request($arguments);
    }
}
