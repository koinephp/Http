<?php

namespace KoineTests\Http;

use Koine\Http\Response;
use Koine\Http\Headers;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class ResponseTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Response();
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

        $object = new Response(array('headers' => $headers));

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
}
