<?php

namespace Tale\Test;

use Some\Test\OtherTestClass;
use Some\Test\TestClass;
use Tale\Loader;

class LoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testLoader()
    {

        $loader = Loader::create();
        $this->assertInstanceOf(Loader\PsrLoader::class, $loader);
        $loader->add('Some\\Test\\', __DIR__.'/library/Test');
        $loader->register();

        $this->assertTrue($loader->isRegistered());
        $obj = new TestClass();
        $this->assertInstanceOf(TestClass::class, $obj);

        $loader->unregister();
        $this->assertFalse($loader->isRegistered());
    }

    public function testComposerLoader()
    {

        $loader = Loader::create(include __DIR__.'/../vendor/autoload.php');
        $this->assertInstanceOf(Loader\ComposerLoader::class, $loader);
        $loader->add('Some\\Test\\', __DIR__.'/library/Test');
        $loader->register();

        $this->assertTrue($loader->isRegistered());
        $obj = new OtherTestClass();
        $this->assertInstanceOf(OtherTestClass::class, $obj);

        $loader->unregister();
        $this->assertFalse($loader->isRegistered());
    }
}