<?php

namespace Codelicious\Tests\Coda\LineParsers;

class NewStateLineParserTest extends \PHPUnit_Framework_TestCase
{
	public function testSample1()
	{
        $parser = new \Codelicious\Coda\LineParsers\NewStateLineParser();

        $sample = "8225001548226815 EUR0BE                  1000000500012100120515                                                                0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("225", $result->getStatementSequenceNumber());
		$this->assertEquals("001548226815 EUR0BE                  ", $result->getAccount());
		$this->assertEquals(-500012.100, $result->getBalance());
		$this->assertEquals("2015-05-12", $result->getDate());
	}
}
