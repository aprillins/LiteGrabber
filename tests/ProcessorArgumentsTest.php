<?php

use Aprillins\LiteGrabber\Classes\ProcessorArguments;

class ProcessorArgumentsTest extends PHPUnit_Framework_TestCase
{
    private $pa;

    public function setUp()
    {
        $this->pa = new ProcessorArguments('get', ['the', 'args'], '//div/img/@src');
    }

    public function testIfGetMethodReturnsEquals()
    {
        $method = $this->pa->getMethod();
        $this->assertEquals('get', $method);
    }

    public function testIfProcessorArgumentsCanBeInstantiated()
    {
        $this->assertInstanceOf('Aprillins\LiteGrabber\Classes\ProcessorArguments', $this->pa, 'WORKS!');
    }
}