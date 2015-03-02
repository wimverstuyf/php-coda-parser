<?php

namespace Codelicious\Tests\Coda\DetailParsers;

class TransformToSimplifiedTest extends \PHPUnit_Framework_TestCase
{
    public function testSample1()
    {
        $transform = new \Codelicious\Coda\DetailParsers\TransformToSimplified();

        $object = $this->createSample1();

        $at = $transform->transform($object);
        
        $this->assertNotEmpty($at->account);
        $this->assertEquals(3, count($at->transactions));
        $this->assertEquals("2015-01-18", $at->date);
        $this->assertEquals(-4004.1, $at->original_balance);
        $this->assertEquals(500012.1, $at->new_balance);
        $this->assertEquals("THIS IS A PUBLIC MESSAGE", $at->free_message);

        $this->assertEquals("CODELICIOUS", $at->account->name);
        $this->assertEquals("GEBABEBB", $at->account->bic);
        $this->assertEquals("09029308273", $at->account->company_id);
        $this->assertEquals("001548226815", $at->account->number);
        $this->assertEquals("EUR", $at->account->currency);
        $this->assertEquals("BE", $at->account->country);

        $tr1 = $at->transactions[0];
        $tr2 = $at->transactions[1];
        $tr3 = $at->transactions[2];

        $this->assertNotEmpty($tr1->account);
        $this->assertEquals("2014-12-25", $tr1->transaction_date);
        $this->assertEquals("2014-12-25", $tr1->valuta_date);
        $this->assertEquals(767.823, $tr1->amount);
        $this->assertEquals("112/4554/46812   813ANOTHER MESSAGEMESSAGE", $tr1->message);
        $this->assertEmpty($tr1->structured_message);

        $this->assertEquals("BVBA.BAKKER PIET", $tr1->account->name);
        $this->assertEquals("GEBCEEBB", $tr1->account->bic);
        $this->assertEmpty($tr1->account->company_id);
        $this->assertEquals("BE54805480215856", $tr1->account->number);
        $this->assertEquals("EUR", $tr1->account->currency);
        $this->assertEmpty($tr1->account->country);

        $this->assertEquals("", $tr2->message);
        $this->assertEquals("112455446812", $tr2->structured_message);

        $this->assertEmpty($tr3->account->name);
        $this->assertEquals("GEBCEEBB", $tr3->account->bic);
    }

    public function createSample1()
    {
        $parser = new \Codelicious\Coda\Parser();

        $content = array(
        "0000018011520105        0938409934CODELICIOUS               GEBABEBB   09029308273 00001          984309          834080       2",
        "10155001548226815 EUR0BE                  0000000004004100241214CODELICIOUS               PROFESSIONAL ACCOUNT               255",
        "21000100000001200002835        1000000000767823251214001120000112/4554/46812   813                                 25121421401 0",
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
        "4 00010005                      THIS IS A PUBLIC MESSAGE                                                                       0",
        "9               000015000000016837520000000003967220                                                                           1",
        );

        $result = $parser->parse($content);
        return $result[0];
    }
}
