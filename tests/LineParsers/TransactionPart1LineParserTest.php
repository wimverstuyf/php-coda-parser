<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\TransactionPart1LineParser;
use Codelicious\Coda\Statements\SepaDirectDebit;

class TransactionPart1LineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new TransactionPart1LineParser();

        $sample = "21000100000001200002835        0000000001767820251214001120000112/4554/46812   813                                 25121421401 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->getSequenceNumber());
		$this->assertEquals("0000", $result->getSequenceNumberDetail());
		$this->assertEquals("0001200002835", $result->getBankReference());
		$this->assertEquals(1767.820, $result->getAmount());
		$this->assertEquals("2014-12-25", $result->getValutaDate());
		$this->assertEquals("00112000", $result->getTransactionCode());
		$this->assertEquals("112/4554/46812   813 ", $result->getMessage());
		$this->assertFalse($result->isHasStructuredMessage());
		$this->assertEquals(NULL, $result->getStructuredMessageType());
		$this->assertEquals(NULL, $result->getStructuredMessageFull());
		$this->assertEquals(NULL, $result->getStructuredMessage());
		$this->assertEquals("2014-12-25", $result->getTransactionDate());
		$this->assertEquals("214", $result->getStatementSequenceNumber());
		$this->assertEquals("0", $result->getGlobalizationCode());
    }

    public function testSampleWithStructuredMessage()
    {
        $parser = new TransactionPart1LineParser();

        $sample = "21000100000001200002835        0000000002767820251214001120001101112455446812  813                                 25121421401 0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->getSequenceNumber());
		$this->assertEquals("0000", $result->getSequenceNumberDetail());
		$this->assertEquals("0001200002835", $result->getBankReference());
		$this->assertEquals(2767.820, $result->getAmount());
		$this->assertEquals("2014-12-25", $result->getValutaDate());
		$this->assertEquals("00112000", $result->getTransactionCode());
		$this->assertEmpty($result->getMessage());
		$this->assertTrue($result->isHasStructuredMessage());
		$this->assertEquals("101", $result->getStructuredMessageType());
		$this->assertEquals("112455446812  813                                 ", $result->getStructuredMessageFull());
		$this->assertEquals("112455446812", $result->getStructuredMessage());
		$this->assertEquals("2014-12-25", $result->getTransactionDate());
		$this->assertEquals("214", $result->getStatementSequenceNumber());
		$this->assertEquals("0", $result->getGlobalizationCode());
    }
	
	public function testSepaDirectDebit()
	{
		$parser = new TransactionPart1LineParser();
		
		$sample = '2100280000VAAS00026BSDDXXXXXXXX1000000000050000050815005030001127050815112BEA123XXXXXXXXXXX                  M123  25121421401 0';
		
		$this->assertEquals(true, $parser->canAcceptString($sample));
		
		$result = $parser->parse($sample);
		$this->assertEquals("0028", $result->getSequenceNumber());
		$this->assertEquals("0000", $result->getSequenceNumberDetail());
		$this->assertEquals("VAAS00026BSDDXXXXXXXX", $result->getBankReference());
		$this->assertEquals(-50, $result->getAmount());
		$this->assertEquals("2015-08-05", $result->getValutaDate());
		$this->assertEquals("00503000", $result->getTransactionCode());
		$this->assertEquals('0', $result->getTransactionCodeType());
		$this->assertEquals('05', $result->getTransactionCodeFamily());
		$this->assertEquals('03', $result->getTransactionCodeOperation());
		$this->assertEquals('000', $result->getTransactionCodeCategory());
		$this->assertEmpty($result->getMessage());
		$this->assertTrue($result->isHasStructuredMessage());
		$this->assertEquals('127', $result->getStructuredMessageType());
		$this->assertEquals('050815112BEA123XXXXXXXXXXX                  M123  ', $result->getStructuredMessageFull());
		$this->assertEquals(NULL, $result->getStructuredMessage());
		$this->assertEquals("2014-12-25", $result->getTransactionDate());
		$this->assertEquals("214", $result->getStatementSequenceNumber());
		$this->assertEquals("0", $result->getGlobalizationCode());
		
		/** @var SepaDirectDebit $sepaDirectDebit */
		$sepaDirectDebit = $result->getSepaDirectDebit();
		$this->assertEquals('2015-08-05', $sepaDirectDebit->getSettlementDate());
		$this->assertEquals('1', $sepaDirectDebit->getType());
		$this->assertEquals('1', $sepaDirectDebit->getScheme());
		$this->assertEquals('2', $sepaDirectDebit->getPaidReason());
		$this->assertEquals('BEA123XXXXXXXXXXX', $sepaDirectDebit->getCreditorIdCode());
		$this->assertEquals('M123', $sepaDirectDebit->getMandateRef());
		$this->assertEquals('', $sepaDirectDebit->getCommunication());
		$this->assertEquals('', $sepaDirectDebit->getTypeRRef());
		$this->assertEquals('', $sepaDirectDebit->getReason());
	}
	
}
