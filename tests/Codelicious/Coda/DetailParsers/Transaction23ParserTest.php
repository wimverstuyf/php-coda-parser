<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class Transaction23ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\Transaction23Parser();

        $sample = "2300010000BE54805480215856                  EURBVBA.BAKKER PIET                         MESSAGE                              0 1";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->sequence_number);
		$this->assertEquals("0000", $result->sequence_number_detail);
		$this->assertEquals("BE54805480215856                  EUR", $result->account_number_and_currency_other_party);
		$this->assertEquals("BVBA.BAKKER PIET", $result->account_name_other_party);
		$this->assertEquals("MESSAGE", $result->message);
    }
}
