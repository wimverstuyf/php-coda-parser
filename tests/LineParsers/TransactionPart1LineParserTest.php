<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\TransactionPart1LineParser;
use Codelicious\Coda\Values\SepaDirectDebit;
use DateTime;

class TransactionPart1LineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new TransactionPart1LineParser();

        $sample = "21000100000001200002835        0000000001767820251214001120000112/4554/46812   813                                 25121421401 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(1, $result->getSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getSequenceNumberDetail()->getValue());
		$this->assertEquals("0001200002835", $result->getBankReference()->getValue());
		$this->assertEquals(1767.820, $result->getAmount()->getValue());
		$this->assertEquals(new DateTime("2014-12-25"), $result->getValutaDate()->getValue());
		$this->assertEquals("0", $result->getTransactionCode()->getType()->getValue());
	    $this->assertEquals("01", $result->getTransactionCode()->getFamily()->getValue());
	    $this->assertEquals("12", $result->getTransactionCode()->getOperation()->getValue());
	    $this->assertEquals("000", $result->getTransactionCode()->getCategory()->getValue());
		$this->assertEquals("112/4554/46812   813 ", $result->getMessageOrStructuredMessage()->getMessage()->getValue());
		$this->assertNull($result->getMessageOrStructuredMessage()->getStructuredMessage());
		$this->assertEquals(new DateTime("2014-12-25"), $result->getTransactionDate()->getValue());
		$this->assertEquals(214, $result->getStatementSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getGlobalizationCode()->getValue());
    }

    public function testSampleWithStructuredMessage()
    {
        $parser = new TransactionPart1LineParser();

        $sample = "21000100000001200002835        0000000002767820251214001120001101112455446812  813                                 25121421401 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(1, $result->getSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getSequenceNumberDetail()->getValue());
		$this->assertEquals("0001200002835", $result->getBankReference()->getValue());
		$this->assertEquals(2767.820, $result->getAmount()->getValue());
		$this->assertEquals(new DateTime("2014-12-25"), $result->getValutaDate()->getValue());
	    $this->assertEquals("0", $result->getTransactionCode()->getType()->getValue());
	    $this->assertEquals("01", $result->getTransactionCode()->getFamily()->getValue());
	    $this->assertEquals("12", $result->getTransactionCode()->getOperation()->getValue());
	    $this->assertEquals("000", $result->getTransactionCode()->getCategory()->getValue());
		$this->assertNull($result->getMessageOrStructuredMessage()->getMessage());
		$this->assertNotNull($result->getMessageOrStructuredMessage()->getStructuredMessage());
		$this->assertEquals("101", $result->getMessageOrStructuredMessage()->getStructuredMessage()->getType());
		$this->assertEquals("112455446812  813                                 ", $result->getMessageOrStructuredMessage()->getStructuredMessage()->getAll());
		$this->assertEquals("112455446812", $result->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage());
		$this->assertEquals(new DateTime("2014-12-25"), $result->getTransactionDate()->getValue());
		$this->assertEquals(214, $result->getStatementSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getGlobalizationCode()->getValue());
    }
	
	public function testSepaDirectDebit()
	{
		$parser = new TransactionPart1LineParser();
		
		$sample = '2100280000VAAS00026BSDDXXXXXXXX1000000000050000050815005030001127050815112BEA123XXXXXXXXXXX                  M123  25121421401 0';
		
		$this->assertEquals(true, $parser->canAcceptString($sample));
		
		$result = $parser->parse($sample);
		$this->assertEquals(28, $result->getSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getSequenceNumberDetail()->getValue());
		$this->assertEquals("VAAS00026BSDDXXXXXXXX", $result->getBankReference()->getValue());
		$this->assertEquals(-50, $result->getAmount()->getValue());
		$this->assertEquals(new DateTime("2015-08-05"), $result->getValutaDate()->getValue());
		$this->assertEquals("0", $result->getTransactionCode()->getType()->getValue());
		$this->assertEquals("05", $result->getTransactionCode()->getFamily()->getValue());
		$this->assertEquals("03", $result->getTransactionCode()->getOperation()->getValue());
		$this->assertEquals("000", $result->getTransactionCode()->getCategory()->getValue());
		$this->assertNull($result->getMessageOrStructuredMessage()->getMessage());
		$this->assertNotNull($result->getMessageOrStructuredMessage()->getStructuredMessage());
		$this->assertEquals('127', $result->getMessageOrStructuredMessage()->getStructuredMessage()->getType());
		$this->assertEquals('050815112BEA123XXXXXXXXXXX                  M123  ', $result->getMessageOrStructuredMessage()->getStructuredMessage()->getAll());
		$this->assertEmpty($result->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage());
		$this->assertEquals(new DateTime("2014-12-25"), $result->getTransactionDate()->getValue());
		$this->assertEquals(214, $result->getStatementSequenceNumber()->getValue());
		$this->assertEquals(0, $result->getGlobalizationCode()->getValue());
		
		/** @var SepaDirectDebit $sepaDirectDebit */
		$sepaDirectDebit = $result->getMessageOrStructuredMessage()->getStructuredMessage()->getSepaDirectDebit();
		$this->assertNotNull($sepaDirectDebit);
		$this->assertEquals(new DateTime('2015-08-05'), $sepaDirectDebit->getSettlementDate()->getValue());
		$this->assertEquals(1, $sepaDirectDebit->getType());
		$this->assertEquals(1, $sepaDirectDebit->getScheme());
		$this->assertEquals(2, $sepaDirectDebit->getPaidReason());
		$this->assertEquals('BEA123XXXXXXXXXXX', $sepaDirectDebit->getCreditorIdentificationCode());
		$this->assertEquals('M123', $sepaDirectDebit->getMandateReference());
	}
	
}
