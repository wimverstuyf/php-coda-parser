<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class SummaryParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\SummaryParser();

        $sample = "9               000015000000016837520000000003967220                                                                           1";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(16837520, $result->debet_amount);
		$this->assertEquals(3967220, $result->credit_amount);
    }
}
