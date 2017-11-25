<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\EndSummaryLineParser;

class EndSummaryLineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new EndSummaryLineParser();

        $sample = "9               000015000000016837520000000003967220                                                                           1";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(16837.520, $result->getDebetAmount()->getValue());
		$this->assertEquals(3967.220, $result->getCreditAmount()->getValue());
    }
}
