<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\MessageLineParser;

class MessageLineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new MessageLineParser();

        $sample = "4 00010005                      THIS IS A PUBLIC MESSAGE                                                                       0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(1, $result->getSequenceNumber()->getValue());
        $this->assertEquals(5, $result->getSequenceNumberDetail()->getValue());
		$this->assertEquals("THIS IS A PUBLIC MESSAGE ", $result->getContent()->getValue());
    }

    public function testSample2()
    {
        $parser = new MessageLineParser();

        $sample = "4 00020000                                              ACCOUNT INFORMATION                                                    1";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(2, $result->getSequenceNumber()->getValue());
        $this->assertEquals(0, $result->getSequenceNumberDetail()->getValue());
		$this->assertEquals(" ACCOUNT INFORMATION ", $result->getContent()->getValue());
    }
}
