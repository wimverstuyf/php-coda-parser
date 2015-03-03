<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class Transaction33ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\Transaction33Parser();

        $sample = "3300010001SOME INFORMATION ABOUT THIS TRANSACTION                                                                            0 0";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

        $this->assertEquals("0001", $result->sequence_number);
        $this->assertEquals("0001", $result->sequence_number_detail);
        $this->assertEquals("SOME INFORMATION ABOUT THIS TRANSACTION", $result->message);
    }
}
