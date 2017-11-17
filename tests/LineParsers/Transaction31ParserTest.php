<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\InformationPart1LineParser;

class Transaction31ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new InformationPart1LineParser();

        $sample = "31000100010007500005482        004800001001BVBA.BAKKER PIET                                                                  1 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

        $this->assertEquals("0001", $result->getSequenceNumber());
        $this->assertEquals("0001", $result->getSequenceNumberDetail());
        $this->assertEquals("0007500005482", $result->getBankReference());
        $this->assertEquals("00480000", $result->getTransactionCode());
        $this->assertEmpty($result->getMessage());
        $this->assertTrue($result->isHasStructuredMessage());
        $this->assertEquals("001", $result->getStructuredMessageType());
        $this->assertEquals("BVBA.BAKKER PIET                                                      ", $result->getStructuredMessageFull());
        $this->assertEmpty($result->getStructuredMessage());
    }
}
