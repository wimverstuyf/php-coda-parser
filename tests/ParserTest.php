<?php

namespace Codelicious\Tests\Coda;

use Codelicious\Coda\Parser;
use Codelicious\Coda\Statements\Statement;
use Codelicious\Coda\Statements\Transaction;
use DateTime;

class ParserTest extends \PHPUnit\Framework\TestCase
{
    public function testSample5SimpleFormat()
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
        $this->assertEquals(1, $transaction1->getTransactionSequence());
        $this->assertEquals(214, $transaction1->getStatementSequence());

        $this->assertNotEmpty($transaction2->getAccount());
        $this->assertNotEmpty($transaction2->getTransactionDate());
        $this->assertNotEmpty($transaction2->getValutaDate());
        $this->assertNotEmpty($transaction2->getStructuredMessage());
        $this->assertEquals(2, $transaction2->getTransactionSequence());
        $this->assertEquals(214, $transaction2->getStatementSequence());

        $this->assertNotEmpty($transaction3->getAccount());
        $this->assertNotEmpty($transaction3->getTransactionDate());
        $this->assertNotEmpty($transaction3->getValutaDate());
        $this->assertNotEmpty($transaction3->getMessage());
        $this->assertEquals(9, $transaction3->getTransactionSequence());
        $this->assertEquals(214, $transaction3->getStatementSequence());
    }

    public function testMessageOnMultipleLinesTransactionBlock()
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
        $this->assertEquals("Zichtrekening nr  21354598  - 2,11Justification in annex 00001680", $result[0]->getTransactions()[0]->getMessage());
    }

    public function testHas4EntriesWithStructuredMessage()
    {
        $parser = new Parser();
        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample1.cod'));

        $this->assertCount(1, $result);
        $this->assertEquals(17752.12, $result[0]->getInitialBalance());
        $this->assertEquals(17832.12, $result[0]->getNewBalance());
        $this->assertEquals(new DateTime("2017-10-11"), $result[0]->getDate());
        $this->assertEmpty($result[0]->getInformationalMessage());

        $this->assertCount(4, $result[0]->getTransactions());
        $this->assertEquals("GROTE WEG            32            3215    HASSELT", $result[0]->getTransactions()[0]->getMessage());
        $this->assertEquals("000003505158", $result[0]->getTransactions()[0]->getStructuredMessage());
        $this->assertEquals(5, $result[0]->getTransactions()[0]->getAmount());
        $this->assertEquals("KLANT1 MET NAAM1", $result[0]->getTransactions()[0]->getAccount()->getName());
        $this->assertEquals("BE22313215646432", $result[0]->getTransactions()[0]->getAccount()->getNumber());
    }

    public function testSample6()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample6.cod'));

        $this->assertCount(1, $result);
        $statement = $result[0];

        $this->assertNotEmpty($statement->getAccount());
        $this->assertEquals(3, count($statement->getTransactions()));
        $this->assertEquals(new DateTime("2015-01-18"), $statement->getDate());
        $this->assertEquals(4004.1, $statement->getInitialBalance());
        $this->assertEquals(-500012.1, $statement->getNewBalance());
        $this->assertEquals("THIS IS A PUBLIC MESSAGE", $statement->getInformationalMessage());

        $this->assertEquals("CODELICIOUS", $statement->getAccount()->getName());
        $this->assertEquals("GEBABEBB", $statement->getAccount()->getBic());
        $this->assertEquals("09029308273", $statement->getAccount()->getCompanyIdentificationNumber());
        $this->assertEquals("001548226815", $statement->getAccount()->getNumber());
        $this->assertEquals("EUR", $statement->getAccount()->getCurrencyCode());
        $this->assertEquals("BE", $statement->getAccount()->getCountryCode());
        $this->assertEquals("PROFESSIONAL ACCOUNT", $statement->getAccount()->getDescription());

        $transaction1 = $statement->getTransactions()[0];
        $transaction2 = $statement->getTransactions()[1];
        $transaction3 = $statement->getTransactions()[2];

        $this->assertNotEmpty($transaction1->getAccount());
        $this->assertEquals(new DateTime("2014-12-25"), $transaction1->getTransactionDate());
        $this->assertEquals(new DateTime("2014-12-25"), $transaction1->getValutaDate());
        $this->assertEquals(-767.823, $transaction1->getAmount());
        $this->assertEquals("112/4554/46812   813  ANOTHER MESSAGE  MESSAGE", $transaction1->getMessage());
        $this->assertEmpty($transaction1->getStructuredMessage());

        $this->assertEquals("BVBA.BAKKER PIET", $transaction1->getAccount()->getName());
        $this->assertEquals("GEBCEEBB", $transaction1->getAccount()->getBic());
        $this->assertEquals("BE54805480215856", $transaction1->getAccount()->getNumber());
        $this->assertEquals("EUR", $transaction1->getAccount()->getCurrencyCode());
        $this->assertEquals(1, $transaction1->getTransactionSequence());
        $this->assertEquals(214, $transaction1->getStatementSequence());

        $this->assertEquals("54875", $transaction2->getMessage());
        $this->assertEquals("112455446812", $transaction2->getStructuredMessage());
        $this->assertEquals(2, $transaction2->getTransactionSequence());
        $this->assertEquals(214, $transaction2->getStatementSequence());

        $this->assertEmpty($transaction3->getAccount()->getName());
        $this->assertEquals("GEBCEEBB", $transaction3->getAccount()->getBic());
        $this->assertEquals(9, $transaction3->getTransactionSequence());
        $this->assertEquals(214, $transaction3->getStatementSequence());
    }

    public function testGroupedTransactions()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample7.cod'));

        $this->assertCount(1, $result);

        $this->assertEquals(17752.12, $result[0]->getInitialBalance());
        $this->assertEquals(17832.12, $result[0]->getNewBalance());
        $this->assertEquals(new DateTime("2017-10-11"), $result[0]->getDate());
        $this->assertEmpty($result[0]->getInformationalMessage());

        $this->assertCount(3, $result[0]->getTransactions());
        $this->assertEquals("VOETGANGERSTRAAT 26                1215        ANTWERPEN", $result[0]->getTransactions()[0]->getMessage());
        $this->assertEquals("000003515846", $result[0]->getTransactions()[0]->getStructuredMessage());
        $this->assertEquals(-25, $result[0]->getTransactions()[0]->getAmount());
        $this->assertEquals("KLANT2 NAAM2", $result[0]->getTransactions()[0]->getAccount()->getName());
        $this->assertEquals("BE25646548413215", $result[0]->getTransactions()[0]->getAccount()->getNumber());
        $this->assertEquals(1, $result[0]->getTransactions()[0]->getTransactionSequence());
        $this->assertEquals(2, $result[0]->getTransactions()[0]->getTransactionSequenceDetail());

        $this->assertEquals(1, $result[0]->getTransactions()[1]->getTransactionSequence());
        $this->assertEquals(3, $result[0]->getTransactions()[1]->getTransactionSequenceDetail());

        $this->assertEquals(1, $result[0]->getTransactions()[2]->getTransactionSequence());
        $this->assertEquals(4, $result[0]->getTransactions()[2]->getTransactionSequenceDetail());
    }

    public function testGroupedTransactionsWithSingleTransaction()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample12.cod'));

        $this->assertCount(1, $result);

        $this->assertEquals(17752.12, $result[0]->getInitialBalance());
        $this->assertEquals(17832.12, $result[0]->getNewBalance());
        $this->assertEquals(new DateTime("2017-10-11"), $result[0]->getDate());
        $this->assertEmpty($result[0]->getInformationalMessage());

        $this->assertCount(1, $result[0]->getTransactions());
        $this->assertEquals("VOETGANGERSTRAAT 26                1215        ANTWERPEN", $result[0]->getTransactions()[0]->getMessage());
        $this->assertEquals("000003515846", $result[0]->getTransactions()[0]->getStructuredMessage());
        $this->assertEquals(-25, $result[0]->getTransactions()[0]->getAmount());
        $this->assertEquals("KLANT2 NAAM2", $result[0]->getTransactions()[0]->getAccount()->getName());
        $this->assertEquals("BE25646548413215", $result[0]->getTransactions()[0]->getAccount()->getNumber());
        $this->assertEquals(1, $result[0]->getTransactions()[0]->getTransactionSequence());
        $this->assertEquals(2, $result[0]->getTransactions()[0]->getTransactionSequenceDetail());
    }

    public function testOnlyGroupedTransactions()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample8.cod'));

        $this->assertCount(1, $result);
        $this->assertCount(2, $result[0]->getTransactions());
    }

    public function testClientReference()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample9.cod'));

        $this->assertCount(1, $result);
        $this->assertCount(1, $result[0]->getTransactions());
        $this->assertSame('243690000141', $result[0]->getTransactions()[0]->getClientReference());
    }

    public function testTotaledTransactionsWithDetails()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample10.cod'));

        $this->assertCount(1, $result);

        $this->assertEquals(100, $result[0]->getInitialBalance());
        $this->assertEquals(1100, $result[0]->getNewBalance());
        $this->assertEquals(new DateTime('2024-06-06'), $result[0]->getDate());
        $this->assertEmpty($result[0]->getInformationalMessage());

        $this->assertCount(2, $result[0]->getTransactions());
        $this->assertEquals(250, $result[0]->getTransactions()[0]->getAmount());
        $this->assertEquals('KLANT1 MET NAAM1', $result[0]->getTransactions()[0]->getAccount()->getName());
        $this->assertEquals('BE22313215646432', $result[0]->getTransactions()[0]->getAccount()->getNumber());

        $this->assertEquals(750, $result[0]->getTransactions()[1]->getAmount());
        $this->assertEquals('KLANT2 MET NAAM2', $result[0]->getTransactions()[1]->getAccount()->getName());
        $this->assertEquals('BE25646548413215', $result[0]->getTransactions()[1]->getAccount()->getNumber());
    }

    public function testTotaledTransactionsNoDetails()
    {
        $parser = new Parser();

        /** @var Statement[] $result */
        $result = $parser->parseFile($this->getSamplePath('sample11.cod'));

        $this->assertCount(1, $result);

        $this->assertEquals(100, $result[0]->getInitialBalance());
        $this->assertEquals(1100, $result[0]->getNewBalance());
        $this->assertEquals(new DateTime('2024-06-06'), $result[0]->getDate());
        $this->assertEmpty($result[0]->getInformationalMessage());

        $this->assertCount(1, $result[0]->getTransactions());
        $this->assertEquals(1000, $result[0]->getTransactions()[0]->getAmount());
    }

    private function getSamplePath($sampleFile)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Samples' . DIRECTORY_SEPARATOR . $sampleFile;
    }
}
