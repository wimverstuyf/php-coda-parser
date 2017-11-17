<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class MessageParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\LineParsers\MessageLineParser();

        $sample = "4 00010005                      THIS IS A PUBLIC MESSAGE                                                                       0";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0001", $result->sequence_number);
        $this->assertEquals("0005", $result->sequence_number_detail);
		$this->assertEquals("THIS IS A PUBLIC MESSAGE", $result->content);
    }

    public function testSample2()
    {
        $parser = new \Codelicious\Coda\LineParsers\MessageLineParser();

        $sample = "4 00020000                                              ACCOUNT INFORMATION                                                    1";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("0002", $result->sequence_number);
        $this->assertEquals("0000", $result->sequence_number_detail);
		$this->assertEquals("ACCOUNT INFORMATION", $result->content);
    }
}
