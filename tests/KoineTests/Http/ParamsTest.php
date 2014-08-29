<?php

namespace KoineTess;

use Koine\Http\Params;
use PHPUnit_Framework_TestCase;

/**
 * @author Marcelo Jacobus <marcelo.jacobus@gmail.com>
 */
class ParamsTest extends PHPUnit_Framework_TestCase
{
    protected $object;

    public function setUp()
    {
        $this->object = new Params();
    }

     /**
      * @test
      */
     public function extendsHash()
     {
         $this->assertInstanceOf('Koine\Hash', $this->object);
     }
}
