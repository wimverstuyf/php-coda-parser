<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\InformationPart1LineParser;

class InformationPart1LineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new InformationPart1LineParser();
        $sample = "31000100010007500005482        004800001001BVBA.BAKKER PIET                                                                  1 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));
        $result = $parser->parse($sample);

        $this->assertEquals(1, $result->getSequenceNumber()->getValue());
        $this->assertEquals(1, $result->getSequenceNumberDetail()->getValue());
        $this->assertEquals("0007500005482", $result->getBankReference()->getValue());
        $this->assertEquals("0", $result->getTransactionCode()->getType()->getValue());
	    $this->assertEquals("04", $result->getTransactionCode()->getFamily()->getValue());
	    $this->assertEquals("80", $result->getTransactionCode()->getOperation()->getValue());
	    $this->assertEquals("000", $result->getTransactionCode()->getCategory()->getValue());
        $this->assertNull($result->getMessageOrStructuredMessage()->getMessage());
        $this->assertNotNull($result->getMessageOrStructuredMessage()->getStructuredMessage());
        $this->assertEquals("001", $result->getMessageOrStructuredMessage()->getStructuredMessage()->getType());
        $this->assertEquals("BVBA.BAKKER PIET                                                      ", $result->getMessageOrStructuredMessage()->getStructuredMessage()->getAll());
        $this->assertEmpty($result->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage());
    }
    
    public function testSampleWithAccents()
    {
        $parser = new InformationPart1LineParser();
        $sample = "31000100073403076534383000143  335370000ekeningING Plus BE12 3215 1548 2121 EUR Compte à vue BE25 3215 2158 2315             0 1";

        $this->assertEquals(true, $parser->canAcceptString($sample));
        $result = $parser->parse($sample);

        $this->assertEquals(1, $result->getSequenceNumber()->getValue());
        $this->assertEquals("ekeningING Plus BE12 3215 1548 2121 EUR Compte à vue BE25 3215 2158 2315 ", $result->getMessageOrStructuredMessage()->getMessage()->getValue());

    }
}
