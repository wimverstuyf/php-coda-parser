<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\IdentificationLineParser;
use DateTime;

class IdentificationLineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new IdentificationLineParser();

        $sample = "0000018011520105        0938409934CODELICIOUS               GEBABEBB   09029308273 00001          984309          834080       2";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals(new DateTime("2015-01-18"), $result->getCreationDate()->getValue());
		$this->assertEquals("201",         $result->getBankIdentificationNumber()->getValue());
		$this->assertEquals("05",          $result->getApplicationCode()->getValue());
		$this->assertEquals(false,         $result->isDuplicate());
		$this->assertEquals("0938409934",  $result->getFileReference()->getValue());
		$this->assertEquals("CODELICIOUS", $result->getAccountName()->getValue());
		$this->assertEquals("GEBABEBB",    $result->getAccountBic()->getValue());
		$this->assertEquals("09029308273", $result->getAccountCompanyIdentificationNumber()->getValue());
		$this->assertEquals("00001",       $result->getExternalApplicationCode()->getValue());
		$this->assertEquals("984309",      $result->getTransactionReference()->getValue());
		$this->assertEquals("834080",      $result->getRelatedReference()->getValue());
		$this->assertEquals("2",           $result->getVersionCode()->getValue());
    }
}
