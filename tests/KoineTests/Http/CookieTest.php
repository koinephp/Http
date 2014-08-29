<?php

namespace KoineTests\Http;

use Koine\Http\Cookie;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class CookieTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $array = array();
        $this->object = new Cookie($array);
    }

    /**
     * @test
     */
    public function extendsArrayReference()
    {
        $this->assertInstanceOf('Koine\ArrayReference', $this->object);
    }
}
