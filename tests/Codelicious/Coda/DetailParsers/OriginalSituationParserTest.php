<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class OriginalSituationParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\OriginalSituationParser();

        $sample = "10155001548226815 EUR0BE                  0000000004004100241214CODELICIOUS               PROFESSIONAL ACCOUNT               255";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0", $result->account_number_type);
		$this->assertEquals("155", $result->statement_sequence_number);
		$this->assertEquals("001548226815", $result->account_number);
		$this->assertEquals("EUR", $result->account_currency);
		$this->assertEquals("BE", $result->account_country);
		$this->assertEquals(FALSE, $result->is_iban);
		$this->assertEquals(-4004100, $result->amount);
		$this->assertEquals("2014-12-24", $result->date);
		$this->assertEquals("CODELICIOUS", $result->account_name);
		$this->assertEquals("PROFESSIONAL ACCOUNT", $result->account_description);
		$this->assertEquals("255", $result->sequence_number);
    }
}
