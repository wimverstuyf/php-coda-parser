<?php

namespace Codelicious\Tests\Coda\LineParsers;

use Codelicious\Coda\LineParsers\IdentificationLineParser;

class IdentificationLineParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new IdentificationLineParser();

        $sample = "0000018011520105        0938409934CODELICIOUS               GEBABEBB   09029308273 00001          984309          834080       2";

        $this->assertEquals(true, $parser->canAcceptString($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("2015-01-18",  $result->getCreationDate());
		$this->assertEquals("201",         $result->getBankIdentificationNumber());
		$this->assertEquals("05",          $result->getApplicationCode());
		$this->assertEquals(false,         $result->isDuplicate());
		$this->assertEquals("0938409934",  $result->getFileReference());
		$this->assertEquals("CODELICIOUS", $result->getAccountName());
		$this->assertEquals("GEBABEBB",    $result->getAccountBic());
		$this->assertEquals("09029308273", $result->getAccountCompanyIdentificationNumber());
		$this->assertEquals("00001",       $result->getExternalApplicationCode());
		$this->assertEquals("984309",      $result->getTransactionReference());
		$this->assertEquals("834080",      $result->getRelatedReference());
		$this->assertEquals("2",           $result->getVersionCode());
    }
}
