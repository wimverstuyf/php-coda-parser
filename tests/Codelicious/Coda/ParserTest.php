<?php

namespace Codelicious\Tests\Coda;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testNullReturns()
    {
        $parser = new \Codelicious\Coda\Parser();

        $result = $parser->parse(array());
        $this->assertEquals(NULL, $result);
    }
}
