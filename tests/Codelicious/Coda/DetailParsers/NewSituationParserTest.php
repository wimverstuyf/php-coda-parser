<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class NewSituationParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\NewSituationParser();

        $sample = "8225001548226815 EUR0BE                  1000000500012100120515                                                                0";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("225", $result->statement_sequence_number);
		$this->assertEquals("001548226815", $result->account_number);
        $this->assertEquals(FALSE, $result->is_iban);
        $this->assertEquals("EUR", $result->currency);
        $this->assertEquals("BE", $result->country);
        $this->assertEquals(500012100, $result->amount);
        $this->assertEquals("2015-05-12", $result->date);
    }
}
