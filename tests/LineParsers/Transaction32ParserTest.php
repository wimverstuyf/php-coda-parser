<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\InformationPart2LineParser;

class Transaction32ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new InformationPart2LineParser();

        $sample = "3200010001MAIN STREET 928                    5480 SOME CITY                                                                  0 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

        $this->assertEquals("0001", $result->getSequenceNumber());
        $this->assertEquals("0001", $result->getSequenceNumberDetail());
        $this->assertEquals("MAIN STREET 928                    5480 SOME CITY ", $result->getMessage());
    }
}
