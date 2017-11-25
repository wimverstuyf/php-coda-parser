<?php

namespace Codelicious\Tests\Coda;

use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\LinesParser;
use PHPUnit_Framework_TestCase;

class LinesParserTest extends PHPUnit_Framework_TestCase
{
	public function testSample1()
	{
		$parser = new LinesParser();
		
		/** @var LineInterface[] $result */
		$result = $parser->parseFile($this->getSamplePath('sample5.cod'));
		
		$this->assertCount(16, $result);
		
//		$this->assertNotEmpty($statement->identification);
//		$this->assertNotEmpty($statement->original_situation);
//		$this->assertNotEmpty($statement->new_situation);
//		$this->assertNotEmpty($statement->summary);
//
//		$this->assertEquals(3, count($statement->transactions));
//		$tr1 = $statement->transactions[0];
//		$tr2 = $statement->transactions[1];
//		$tr3 = $statement->transactions[2];
//
//		$this->assertNotEmpty($tr1->line21);
//		$this->assertNotEmpty($tr1->line22);
//		$this->assertNotEmpty($tr1->line23);
//		$this->assertNotEmpty($tr1->line31);
//		$this->assertNotEmpty($tr1->line32);
//		$this->assertNotEmpty($tr1->line33);
//
//		$this->assertNotEmpty($tr2->line21);
//		$this->assertNotEmpty($tr2->line22);
//		$this->assertNotEmpty($tr2->line23);
//		$this->assertNotEmpty($tr2->line31);
//		$this->assertEmpty($tr2->line32);
//		$this->assertEmpty($tr2->line33);
//
//		$this->assertNotEmpty($tr3->line21);
//		$this->assertNotEmpty($tr3->line22);
//		$this->assertEmpty($tr3->line23);
//		$this->assertEmpty($tr3->line31);
//		$this->assertEmpty($tr3->line32);
//		$this->assertEmpty($tr3->line33);
	}
	
	private function getSamplePath($sampleFile)
	{
		return __DIR__ . DIRECTORY_SEPARATOR .'Samples' . DIRECTORY_SEPARATOR . $sampleFile;
	}
}