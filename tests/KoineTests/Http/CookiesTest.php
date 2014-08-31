<?php

namespace KoineTests\Http;

use Koine\Http\Cookies;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class CookiesTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $array = array();
        $this->object = new Cookies($array);
    }

    /**
     * @test
     */
    public function extendsArrayReference()
    {
        $this->assertInstanceOf('Koine\ArrayReference', $this->object);
    }
}
