<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class IdentificationParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $parser = new \Codelicious\Coda\DetailParsers\IdentificationParser();

        $sample = "0000018011520105        0938409934CODELICIOUS               GEBABEBB   09029308273 00001          984309          834080       2";

        $this->assertEquals(TRUE, $parser->accept_string($sample));

        $result = $parser->parse($sample);

		$this->assertEquals("2015-01-18",  $result->creation_date);
		$this->assertEquals("201",         $result->bank_identification_number);
		$this->assertEquals("05",          $result->application_code);
		$this->assertEquals(FALSE,         $result->is_duplicate);
		$this->assertEquals("0938409934",  $result->file_reference);
		$this->assertEquals("CODELICIOUS", $result->recipient_name);
		$this->assertEquals("GEBABEBB",    $result->bic);
		$this->assertEquals("09029308273", $result->account_holder_identification_number);
		$this->assertEquals("00001",       $result->external_application_code);
		$this->assertEquals("984309",      $result->transaction_reference);
		$this->assertEquals("834080",      $result->related_reference);
		$this->assertEquals("2",           $result->version_code);
    }
}
