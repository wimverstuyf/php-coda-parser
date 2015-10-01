<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class Transaction21ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\Transaction21Parser();

        $sample = "21000100000001200002835        0000000001767820251214001120000112/4554/46812   813                                 25121421401 0";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->sequence_number);
		$this->assertEquals("0000", $result->sequence_number_detail);
		$this->assertEquals("0001200002835", $result->bank_reference);
		$this->assertEquals(1767.820, $result->amount);
		$this->assertEquals("2014-12-25", $result->valuta_date);
		$this->assertEquals("00112000", $result->transaction_code);
		$this->assertEquals("112/4554/46812   813 ", $result->message);
		$this->assertFalse($result->has_structured_message);
		$this->assertEquals(NULL, $result->structured_message_type);
		$this->assertEquals(NULL, $result->structured_message_full);
		$this->assertEquals(NULL, $result->structured_message);
		$this->assertEquals("2014-12-25", $result->transaction_date);
		$this->assertEquals("214", $result->statement_sequence_number);
		$this->assertEquals("0", $result->globalization_code);
    }

    public function testSampleWithStructuredMessage()
    {
        $parser = new \Codelicious\Coda\DetailParsers\Transaction21Parser();

        $sample = "21000100000001200002835        0000000002767820251214001120001101112455446812  813                                 25121421401 0";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->sequence_number);
		$this->assertEquals("0000", $result->sequence_number_detail);
		$this->assertEquals("0001200002835", $result->bank_reference);
		$this->assertEquals(2767.820, $result->amount);
		$this->assertEquals("2014-12-25", $result->valuta_date);
		$this->assertEquals("00112000", $result->transaction_code);
		$this->assertEmpty($result->message);
		$this->assertTrue($result->has_structured_message);
		$this->assertEquals("101", $result->structured_message_type);
		$this->assertEquals("112455446812  813                                 ", $result->structured_message_full);
		$this->assertEquals("112455446812", $result->structured_message);
		$this->assertEquals("2014-12-25", $result->transaction_date);
		$this->assertEquals("214", $result->statement_sequence_number);
		$this->assertEquals("0", $result->globalization_code);
    }
}
