<?php

namespace KoineTests\Http;

use Koine\Http\Session;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class SessionTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $array = array();
        $this->object = new Session($array);
    }

    /**
     * @test
     */
    public function extendsArrayReference()
    {
        $this->assertInstanceOf('Koine\ArrayReference', $this->object);
    }
}
