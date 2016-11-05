<?php

namespace Codelicious\Tests\Coda;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    private function getSample1()
    {
        $content = array(
        "0000018011520105        0938409934CODELICIOUS               GEBABEBB   09029308273 00001          984309          834080       2",
        "10155001548226815 EUR0BE                  0000000004004100241214CODELICIOUS               PROFESSIONAL ACCOUNT               255",
        "21000100000001200002835        0000000001767820251214001120000112/4554/46812   813                                 25121421401 0",
        "2200010000  ANOTHER MESSAGE                                           54875                       GEBCEEBB                   1 0",
        "2300010000BE54805480215856                  EURBVBA.BAKKER PIET                         MESSAGE                              0 1",
        "31000100010007500005482        004800001001BVBA.BAKKER PIET                                                                  1 0",
        "3200010001MAIN STREET 928                    5480 SOME CITY                                                                  0 0",
        "3300010001SOME INFORMATION ABOUT THIS TRANSACTION                                                                            0 0",
        "21000200000001200002835        0000000002767820251214001120001101112455446812  813                                 25121421401 0",
        "2200020000  ANOTHER MESSAGE                                           54875                       GEBCEEBB                   1 0",
        "2300020000BE54805480215856                  EURBVBA.BAKKER PIET                         MESSAGE                              0 1",
        "31000200010007500005482        004800001001BVBA.BAKKER PIET                                                                  1 0",
        "21000900000001200002835        0000000001767820251214001120000112/4554/46812   813                                 25121421401 0",
        "2200090000  ANOTHER MESSAGE                                           54875                       GEBCEEBB                   1 0",
        "8225001548226815 EUR0BE                  1000000500012100120515                                                                0",
        "9               000015000000016837520000000003967220                                                                           1",
        );

        return $content;
    }

    public function testSample1()
    {
        $parser = new \Codelicious\Coda\Parser();
        $parser->setDetailParser(array());

        $result = $parser->parse($this->getSample1());

        $this->assertEquals(1, count($result));
        $at = $result[0];

        $this->assertNotEmpty($at->identification);
        $this->assertNotEmpty($at->original_situation);
        $this->assertNotEmpty($at->new_situation);
        $this->assertNotEmpty($at->summary);

        $this->assertEquals(3, count($at->transactions));
        $tr1 = $at->transactions[0];
        $tr2 = $at->transactions[1];
        $tr3 = $at->transactions[2];

        $this->assertNotEmpty($tr1->line21);
        $this->assertNotEmpty($tr1->line22);
        $this->assertNotEmpty($tr1->line23);
        $this->assertNotEmpty($tr1->line31);
        $this->assertNotEmpty($tr1->line32);
        $this->assertNotEmpty($tr1->line33);

        $this->assertNotEmpty($tr2->line21);
        $this->assertNotEmpty($tr2->line22);
        $this->assertNotEmpty($tr2->line23);
        $this->assertNotEmpty($tr2->line31);
        $this->assertEmpty($tr2->line32);
        $this->assertEmpty($tr2->line33);

        $this->assertNotEmpty($tr3->line21);
        $this->assertNotEmpty($tr3->line22);
        $this->assertEmpty($tr3->line23);
        $this->assertEmpty($tr3->line31);
        $this->assertEmpty($tr3->line32);
        $this->assertEmpty($tr3->line33);
    }


    public function testSample1SimpleFormat()
    {
        $parser = new \Codelicious\Coda\Parser();

        $result = $parser->parse($this->getSample1(), "simple");

        $this->assertEquals(1, count($result));
        $at = $result[0];

        $this->assertNotEmpty($at->date);
        $this->assertNotEmpty($at->account);
        $this->assertNotEmpty($at->original_balance);
        $this->assertNotEmpty($at->new_balance);

        $this->assertEquals(3, count($at->transactions));
        $tr1 = $at->transactions[0];
        $tr2 = $at->transactions[1];
        $tr3 = $at->transactions[2];

        $this->assertNotEmpty($tr1->account);
        $this->assertNotEmpty($tr1->transaction_date);
        $this->assertNotEmpty($tr1->valuta_date);
        $this->assertNotEmpty($tr1->message);

        $this->assertNotEmpty($tr2->account);
        $this->assertNotEmpty($tr2->transaction_date);
        $this->assertNotEmpty($tr2->valuta_date);
        $this->assertNotEmpty($tr2->structured_message);

        $this->assertNotEmpty($tr3->account);
        $this->assertNotEmpty($tr3->transaction_date);
        $this->assertNotEmpty($tr3->valuta_date);
        $this->assertNotEmpty($tr3->message);
    }

    public function testSetAndGetParserDetail()
    {
        $parser = new \Codelicious\Coda\Parser();
        $parsers = $parser->getDetailParsers();
        array_pop($parsers);

        $this->assertCount(count($parsers) + 1, $parser->getDetailParsers());
        $parser->setDetailParser($parsers);
        $this->assertCount(count($parsers), $parser->getDetailParsers());
    }
}
