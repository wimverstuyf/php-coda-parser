<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\TransactionPart3LineParser;

class Transaction23ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new TransactionPart3LineParser();

        $sample = "2300010000BE54805480215856                  EURBVBA.BAKKER PIET                         MESSAGE                              0 1";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->getSequenceNumber());
		$this->assertEquals("0000", $result->getSequenceNumberDetail());
		$this->assertEquals("BE54805480215856                  EUR", $result->getOtherAccountNumberAndCurrency());
		$this->assertEquals("BVBA.BAKKER PIET", $result->getOtherAccountName());
		$this->assertEquals(" MESSAGE ", $result->getMessage());
    }
}
