<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class Transaction31ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\Transaction31Parser();

        $sample = "31000100010007500005482        004800001001BVBA.BAKKER PIET                                                                  1 0";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

        $this->assertEquals("0001", $result->sequence_number);
        $this->assertEquals("0001", $result->sequence_number_detail);
        $this->assertEquals("0007500005482", $result->bank_reference);
        $this->assertEquals("00480000", $result->transaction_code);
        $this->assertEmpty($result->message);
        $this->assertTrue($result->has_structured_message);
        $this->assertEquals("001", $result->structured_message_type);
        $this->assertEquals("BVBA.BAKKER PIET                                                      ", $result->structured_message_full);
        $this->assertEmpty($result->structured_message);
    }
}
