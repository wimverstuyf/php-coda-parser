<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\MessageLineParser;

class MessageParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new MessageLineParser();

        $sample = "4 00010005                      THIS IS A PUBLIC MESSAGE                                                                       0";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->getSequenceNumber());
        $this->assertEquals("0005", $result->getSequenceNumberDetail());
		$this->assertEquals("THIS IS A PUBLIC MESSAGE", $result->getContent());
    }

    public function testSample2()
    {
        $parser = new MessageLineParser();

        $sample = "4 00020000                                              ACCOUNT INFORMATION                                                    1";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0002", $result->getSequenceNumber());
        $this->assertEquals("0000", $result->getSequenceNumberDetail());
		$this->assertEquals("ACCOUNT INFORMATION", $result->getContent());
    }
}
