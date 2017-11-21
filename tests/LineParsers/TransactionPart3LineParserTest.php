<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\TransactionPart3LineParser;

class TransactionPart3LineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new TransactionPart3LineParser();

        $sample = "2300010000BE54805480215856                  EURBVBA.BAKKER PIET                         MESSAGE                              0 1";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(1, $result->getSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getSequenceNumberDetail()->getValue());
		$this->assertEquals("BE54805480215856                  EUR", $result->getOtherAccountNumberAndCurrency()->getValue());
		$this->assertEquals("BVBA.BAKKER PIET", $result->getOtherAccountName()->getValue());
		$this->assertEquals(" MESSAGE ", $result->getMessage()->getValue());
    }
}
