<?php

namespace KoineTests\Http;

use Koine\Http\Response;
use Koine\Http\Headers;
use Koine\Http\Environment;
use Koine\Http\Session;
use Koine\Http\Cookies;
use Koine\Http\Params;
use Koine\Http\Request;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    protected $request;

    public function setUp()
    {

        $environment = new Environment(array());

        $params  = array();
        $session = new Session($params);
        $cookies = new Cookies($params);
        $params  = new Params();

        $this->request = new Request(array(
            'environment' => $environment,
            'session'     => $session,
            'cookies'     => $cookies,
            'params'      => $params,
        ));

        $request = $this->request;

        $this->object = new Response($request);
    }

    /**
     * @test
     */
    public function hasHeaders()
    {
        $headers = $this->object->getHeaders();

        $this->assertInstanceOf('Koine\Http\Headers', $headers);
    }

    /**
     * @test
     */
    public function canSetHeaders()
    {
        $headers = new Headers();

        $this->assertSame(
            $headers,
            $this->object->setHeaders($headers)->getHeaders()
        );
    }

    /**
     * @test
     */
    public function canSetHeadersInTheConstructor()
    {
        $headers = new Headers();

        $object = new Response($this->request, array('headers' => $headers));

        $this->assertSame($headers, $object->getHeaders());
    }

    /**
     * @test
     */
    public function bodyIsInitiallyEmpty()
    {
        $this->assertEquals('', $this->object->getBody());
    }

    /**
     * @test
     */
    public function getBody()
    {
        $body = $this->object->setBody('body')->getBody();

        $this->assertEquals('body', $body);
    }

    /**
     * @test
     */
    public function canAppendContentToBody()
    {
        $body = $this->object
            ->setBody('foo')
            ->appendBody(' bar')
            ->getBody();

        $this->assertEquals('foo bar', $body);
    }

    /**
     * @test
     */
    public function canPrependContentToBody()
    {
        $body = $this->object
            ->setBody('foo')
            ->prependBody('bar ')
            ->getBody();

        $this->assertEquals('bar foo', $this->object->getBody());
    }

    /**
     * @test
     */
    public function sendSendHeaders()
    {
        $headers = $this->getMock('Koine\Http\Headers');
        $headers->expects($this->once())
            ->method('send');

        $this->object->setHeaders($headers)->send();
    }

    /**
     * @test
     */
    public function sendEchoesBody()
    {
        $headers = $this->getMock('Koine\Http\Headers');
        $headers->expects($this->once())
            ->method('send');

        $this->expectOutputString('Hello World!');

        $this->object->setHeaders($headers)
            ->setBody('Hello World!')
            ->send();
    }

    /**
     * @test
     */
    public function statusCodeIsInitially200()
    {
        $this->assertEquals(200, $this->object->getStatusCode());
    }

    /**
     * @test
     */
    public function canSetAndGetStatus()
    {
        $status = $this->object->setStatusCode(201)->getStatusCode();

        $this->assertEquals(201, $status);
    }

    /**
     * @test
     * @expectedException Koine\Http\Exceptions\InvalidStatusCodeException
     * @expectedExceptionMessage '90' is an invalid status code
     */
    public function whenStatusCodeIsUnkownItThrowsInvalidStatusCodeException()
    {
        $this->object->setStatusCode(90);
    }

    /**
     * @test
     */
    public function canVerifyIfRequestEmpty()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(404);
        $request2->setStatusCode(201);
        $this->assertFalse($request1->isEmpty());
        $this->assertTrue($request2->isEmpty());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsClientError()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(404);
        $request2->setStatusCode(500);
        $this->assertTrue($request1->isClientError());
        $this->assertFalse($request2->isClientError());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsForbidden()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(403);
        $request2->setStatusCode(500);
        $this->assertTrue($request1->isForbidden());
        $this->assertFalse($request2->isForbidden());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsInformational()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(100);
        $request2->setStatusCode(200);
        $this->assertTrue($request1->isInformational());
        $this->assertFalse($request2->isInformational());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsNotFound()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(404);
        $request2->setStatusCode(200);
        $this->assertTrue($request1->isNotFound());
        $this->assertFalse($request2->isNotFound());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsOk()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(200);
        $request2->setStatusCode(201);
        $this->assertTrue($request1->isOk());
        $this->assertFalse($request2->isOk());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsSuccessful()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request3 = new Response($this->request);
        $request1->setStatusCode(200);
        $request2->setStatusCode(201);
        $request3->setStatusCode(302);
        $this->assertTrue($request1->isSuccessful());
        $this->assertTrue($request2->isSuccessful());
        $this->assertFalse($request3->isSuccessful());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsRedirect()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(307);
        $request2->setStatusCode(304);
        $this->assertTrue($request1->isRedirect());
        $this->assertFalse($request2->isRedirect());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsRedirection()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request3 = new Response($this->request);
        $request1->setStatusCode(307);
        $request2->setStatusCode(304);
        $request3->setStatusCode(200);
        $this->assertTrue($request1->isRedirection());
        $this->assertTrue($request2->isRedirection());
        $this->assertFalse($request3->isRedirection());
    }

    /**
     * @test
     */
    public function canVerifyIfRequestIsServerError()
    {
        $request1 = new Response($this->request);
        $request2 = new Response($this->request);
        $request1->setStatusCode(500);
        $request2->setStatusCode(400);
        $this->assertTrue($request1->isServerError());
        $this->assertFalse($request2->isServerError());
    }

    /**
     * @test
     */
    public function itRedirectsTo()
    {
        $this->object->redirectTo("/index.php");

        $this->assertSame("/index.php", $this->object->getRedirectUrl());

        $this->assertSame(302, $this->object->getStatusCode());

        $this->assertEquals(
            'Location: /index.php',
            $this->object->getHeaders()->offsetGet('Location')
        );

        // second redirect
        $this->object->redirectTo("/index2.php", array(
            'status' => 304
        ));

        $this->assertSame("/index2.php", $this->object->getRedirectUrl());

        $this->assertSame(304, $this->object->getStatusCode());

        $this->assertEquals(
            'Location: /index2.php',
            $this->object->getHeaders()->offsetGet('Location')
        );
    }
}
