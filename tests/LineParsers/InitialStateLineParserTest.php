<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\InitialStateLineParser;
use DateTime;

class InitialStateLineParserTest extends \PHPUnit_Framework_TestCase
{
	public function testSample1()
	{
		$parser = new InitialStateLineParser();

		$sample = "10155001548226815 EUR0BE                  0000000004004100241214CODELICIOUS               PROFESSIONAL ACCOUNT               255";

		$this->assertEquals(true, $parser->canAcceptString($sample));

		$result = $parser->parse($sample);

		$this->assertEquals("0", $result->getAccount()->getNumberType()->getValue());
		$this->assertEquals(155, $result->getStatementSequenceNumber()->getValue());
		$this->assertEquals("001548226815", $result->getAccount()->getNumber()->getValue());
		$this->assertEquals("EUR", $result->getAccount()->getCurrency()->getCurrencyCode());
		$this->assertEquals("BE", $result->getAccount()->getCountry()->getCountryCode());
		$this->assertEquals(false, $result->getAccount()->getNumber()->isIbanNumber());
		$this->assertEquals(4004.100, $result->getBalance()->getValue());
		$this->assertEquals(new DateTime("2014-12-24"), $result->getDate()->getValue());
		$this->assertEquals("CODELICIOUS", $result->getAccount()->getName()->getValue());
		$this->assertEquals("PROFESSIONAL ACCOUNT", $result->getAccount()->getDescription()->getValue());
		$this->assertEquals(255, $result->getPaperStatementSequenceNumber()->getValue());
	}

	public function testAccountIsIbanIsSetCorrectly ()
	{
		$parser = new InitialStateLineParser();

		$sample = "13155001548226815 EUR0BE                  0000000004004100241214CODELICIOUS               PROFESSIONAL ACCOUNT               255";

		$this->assertEquals(true, $parser->canAcceptString($sample));

		$result = $parser->parse($sample);

		$this->assertEquals(true, $result->getAccount()->getNumber()->isIbanNumber());
	}
}
