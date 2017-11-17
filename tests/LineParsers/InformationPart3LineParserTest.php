<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\InformationPart3LineParser;

class InformationPart3LineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new InformationPart3LineParser();

        $sample = "3300010001SOME INFORMATION ABOUT THIS TRANSACTION                                                                            0 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

        $this->assertEquals("0001", $result->getSequenceNumber());
        $this->assertEquals("0001", $result->getSequenceNumberDetail());
        $this->assertEquals("SOME INFORMATION ABOUT THIS TRANSACTION ", $result->getMessage());
    }
}
