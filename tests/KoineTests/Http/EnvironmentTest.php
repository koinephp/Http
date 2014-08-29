<?php

namespace KoineTess;

use Koine\Http\Environment;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class EnvironmentTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Environment();
    }

    /**
     * @test
     */
    public function extendsHash()
    {
        $this->assertInstanceOf('Koine\Hash', $this->object);
    }
}
