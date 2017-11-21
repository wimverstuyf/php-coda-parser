<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\TransactionPart2LineParser;

class TransactionPart2LineParserTest extends \PHPUnit_Framework_TestCase
{
	public function testSample1()
	{
		$parser = new TransactionPart2LineParser();

		$sample = "2200010000  ANOTHER MESSAGE                                           54875                       GEBCEEBB                   1 0";

		$this->assertEquals(true, $parser->canAcceptString($sample));

		$result = $parser->parse($sample);

		$this->assertEquals(1, $result->getSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getSequenceNumberDetail()->getValue());
		$this->assertEquals(" ANOTHER MESSAGE ", $result->getMessage());
		$this->assertEquals("54875", $result->getClientReference());
		$this->assertEquals("GEBCEEBB", $result->getOtherAccountBic());
		$this->assertEquals("", $result->getCategoryPurpose());
		$this->assertEquals("", $result->getPurpose());
	}
}
