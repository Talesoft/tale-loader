<?php

namespace Tale\Test;

use Some\Test\TestClass;
use Tale\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testLoader()
    {

        $loader = new Loader(__DIR__.'/library', 'Some\\');
        $loader->register();

        $obj = new TestClass();
        $this->assertInstanceOf(TestClass::class, $obj);
    }
}