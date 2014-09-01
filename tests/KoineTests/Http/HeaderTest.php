<?php

namespace KoineTests\Http;

use Koine\Http\Header;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class HeaderTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itConvertsToStringCorrectly()
    {
        $header = new Header('Foo');
        $this->assertEquals('Foo', (string) $header);

        $header = new Header('Content-Type', 'application/json');
        $this->assertEquals('Content-Type: application/json', (string) $header);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function sendsHeader()
    {
        $header = new Header('Content-Type', 'application/json');
        $header->send();
    }
}
