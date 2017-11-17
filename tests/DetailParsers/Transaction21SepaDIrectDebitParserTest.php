<?php

namespace Codelicious\Tests\Coda\DetailParsers;

use \Codelicious\Coda\LineParsers\TransactionPart1SepaDirectDebitParser;

class Transaction21SepaDirectDebitParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
			$parser = new TransactionPart1SepaDirectDebitParser();

			$sample = '2100280000VAAS00026BSDDXXXXXXXX1000000000050000050815005030001127050815112BEA123XXXXXXXXXXX                  M123  25121421401 0';

			$this->assertEquals(true, $parser->accept_string($sample));

			$result = $parser->parse($sample);
			$this->assertEquals("0028", $result->sequence_number);
			$this->assertEquals("0000", $result->sequence_number_detail);
			$this->assertEquals("VAAS00026BSDDXXXXXXXX", $result->bank_reference);
			$this->assertEquals(-50, $result->amount);
			$this->assertEquals("2015-08-05", $result->valuta_date);
			$this->assertEquals("00503000", $result->transaction_code);
			$this->assertEquals('0', $result->transaction_code_type);
			$this->assertEquals('05', $result->transaction_code_family);
			$this->assertEquals('03', $result->transaction_code_operation);
			$this->assertEquals('000', $result->transaction_code_category);
			$this->assertNull($result->message);
			$this->assertTrue($result->has_structured_message);
			$this->assertEquals('127', $result->structured_message_type);
			$this->assertEquals('050815112BEA123XXXXXXXXXXX                  M123  ', $result->structured_message_full);
			$this->assertEquals(NULL, $result->structured_message);
			$this->assertEquals("2014-12-25", $result->transaction_date);
			$this->assertEquals("214", $result->statement_sequence_number);
			$this->assertEquals("0", $result->globalization_code);

			$this->assertEquals('2015-08-05', $result->sepa_direct_debit_settlement_date);
			$this->assertEquals('1', $result->sepa_direct_debit_type);
			$this->assertEquals('1', $result->sepa_direct_debit_scheme);
			$this->assertEquals('2', $result->sepa_direct_debit_paid_reason);
			$this->assertEquals('BEA123XXXXXXXXXXX', $result->sepa_direct_debit_creditor_id_code);
			$this->assertEquals('M123', $result->sepa_direct_debit_mandate_ref);
			$this->assertEquals('', $result->sepa_direct_debit_communication);
			$this->assertEquals('', $result->sepa_direct_debit_type_r_ref);
			$this->assertEquals('', $result->sepa_direct_debit_reason);
    }
}
