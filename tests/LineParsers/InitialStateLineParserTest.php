<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\InitialStateLineParser;

class InitialStateLineParserTest extends \PHPUnit_Framework_TestCase
{
	public function testSample1()
	{
		$parser = new InitialStateLineParser();

		$sample = "10155001548226815 EUR0BE                  0000000004004100241214CODELICIOUS               PROFESSIONAL ACCOUNT               255";

		$this->assertEquals(true, $parser->canAcceptString($sample));

		$result = $parser->parse($sample);

		$this->assertEquals("0", $result->getAccountNumberType());
		$this->assertEquals("155", $result->getStatementSequenceNumber());
		$this->assertEquals("001548226815", $result->getAccountNumber());
		$this->assertEquals("EUR", $result->getAccountCurrency());
		$this->assertEquals("BE", $result->getAccountCountry());
		$this->assertEquals(false, $result->isAccountIsIban());
		$this->assertEquals(4004.100, $result->getBalance());
		$this->assertEquals("2014-12-24", $result->getDate());
		$this->assertEquals("CODELICIOUS", $result->getAccountName());
		$this->assertEquals("PROFESSIONAL ACCOUNT", $result->getAccountDescription());
		$this->assertEquals("255", $result->getPaperStatementSequenceNumber());
	}

	public function testAccountIsIbanIsSetCorrectly ()
	{
		$parser = new InitialStateLineParser();

		$sample = "13155001548226815 EUR0BE                  0000000004004100241214CODELICIOUS               PROFESSIONAL ACCOUNT               255";

		$this->assertEquals(true, $parser->canAcceptString($sample));

		$result = $parser->parse($sample);

		$this->assertEquals(true, $result->isAccountIsIban());
	}
}
