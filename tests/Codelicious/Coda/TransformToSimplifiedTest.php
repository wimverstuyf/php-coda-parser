<?php

namespace Codelicious\Tests\Coda;

class TransformToSimplifiedTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $transform = new \Codelicious\Coda\TransformToSimplified();

        $object = $this->createSample1();

        //$result = $transform->transform($object);
        
        // TODO: check content in result
    }

    public function createSample1()
    {
    	return new \stdClass();
    }
}
