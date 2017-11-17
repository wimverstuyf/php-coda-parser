<?php

namespace Codelicious\Tests\Coda;

use Codelicious\Coda\Parser;
use Codelicious\Coda\Statements\Statement;
use Codelicious\Coda\Statements\Transaction;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1SimpleFormat()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample5.cod'));

        $this->assertCount(1, $result);
        $statement = $result[0];

        $this->assertNotEmpty($statement->getDate());
        $this->assertNotEmpty($statement->getAccount());
        $this->assertNotEmpty($statement->getInitialBalance());
        $this->assertNotEmpty($statement->getNewBalance());

        $this->assertEquals(3, count($statement->getTransactions()));
        /** @var Transaction[] $transactions */
        $transactions = $statement->getTransactions();
        $transaction1 = $transactions[0];
        $transaction2 = $transactions[1];
        $transaction3 = $transactions[2];

        $this->assertNotEmpty($transaction1->getAccount());
        $this->assertNotEmpty($transaction1->getTransactionDate());
        $this->assertNotEmpty($transaction1->getValutaDate());
        $this->assertNotEmpty($transaction1->getMessage());

        $this->assertNotEmpty($transaction2->getAccount());
        $this->assertNotEmpty($transaction2->getTransactionDate());
        $this->assertNotEmpty($transaction2->getValutaDate());
        $this->assertNotEmpty($transaction2->getStructuredMessage());

        $this->assertNotEmpty($transaction3->getAccount());
        $this->assertNotEmpty($transaction3->getTransactionDate());
        $this->assertNotEmpty($transaction3->getValutaDate());
        $this->assertNotEmpty($transaction3->getMessage());
    }

	public function testMessageOnMultipleLinesMovementBlock()
	{
		$parser = new Parser();
		/** @var Statement[] $result */
		$result = $parser->parseFile($this->getSamplePath('sample3.cod'));
		
		$this->assertEquals("Message goes here and continues here or here", $result[0]->getTransactions()[0]->getMessage());
	}
	
	public function testMessageOnMultipleLinesInformationBlock()
	{
		$parser = new Parser();
		/** @var Statement[] $result */
		$result = $parser->parseFile($this->getSamplePath('sample4.cod'));
		
		$this->assertEquals("Europese overschrijving (zie bijlage)  + 17.233,54Van: COMPANY BLABLABLAH BVBA - BE64NOT PR", $result[0]->getTransactions()[0]->getMessage());
	}
	
	public function testNoAccount()
	{
		$parser = new Parser();
		/** @var Statement[] $result */
		$result = $parser->parseFile($this->getSamplePath('sample2.cod'));
		
		$this->assertEmpty($result[0]->getTransactions()[0]->getAccount()->getName());
		$this->assertEquals("Zichtrekening nr  21354598   - 2,11Justification in annex 00001680", $result[0]->getTransactions()[0]->getMessage());
	}
	
	public function testHas4EntriesWithStructuredMessage()
	{
		$parser = new Parser();
		/** @var Statement[] $result */
		$result = $parser->parseFile($this->getSamplePath('sample1.cod'));
		
		$this->assertCount(1, $result);
		$this->assertEquals(17752.12, $result[0]->getInitialBalance());
		$this->assertEquals(17832.12, $result[0]->getNewBalance());
		$this->assertEquals("2017-10-11", $result[0]->getDate());
		$this->assertEmpty($result[0]->getInformationalMessage());
		
		$this->assertCount(4, $result[0]->getTransactions());
		$this->assertEmpty($result[0]->getTransactions()[0]->getMessage());
		$this->assertEquals("000003505158", $result[0]->getTransactions()[0]->getStructuredMessage());
		$this->assertEquals(5, $result[0]->getTransactions()[0]->getAmount());
		$this->assertEquals("KLANT1 MET NAAM1", $result[0]->getTransactions()[0]->getAccount()->getName());
		$this->assertEquals("BE22313215646432", $result[0]->getTransactions()[0]->getAccount()->getNumber());
	}
	
	private function getSamplePath($sampleFile)
	{
		return __DIR__ . DIRECTORY_SEPARATOR .'Samples' . DIRECTORY_SEPARATOR . $sampleFile;
	}

}
