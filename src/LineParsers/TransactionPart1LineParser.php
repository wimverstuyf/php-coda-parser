<?php

namespace Codelicious\Coda\LineParsers;

use Codelicious\Coda\Lines\TransactionPart1Line;
use Codelicious\Coda\Statements\SepaDirectDebit;
use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\BankReference;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\GlobalizationCode;
use Codelicious\Coda\Values\MessageOrStructuredMessage;
use Codelicious\Coda\Values\SequenceNumber;
use Codelicious\Coda\Values\SequenceNumberDetail;
use Codelicious\Coda\Values\StatementSequenceNumber;
use Codelicious\Coda\Values\TransactionCode;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart1LineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return TransactionPart1Line
	 */
	public function parse(string $codaLine)
	{
		$transactionCode = new TransactionCode(mb_substr($codaLine, 53, 8));
		
		return new TransactionPart1Line(
			new SequenceNumber(mb_substr($codaLine, 2, 4)),
			new SequenceNumberDetail(mb_substr($codaLine, 6, 4)),
			new BankReference(mb_substr($codaLine, 10, 21)),
			new Amount(mb_substr($codaLine, 31, 1).mb_substr($codaLine, 32, 15), true),
			new Date(mb_substr($codaLine, 47, 6)),
			$transactionCode,
			new MessageOrStructuredMessage(mb_substr($codaLine, 61, 54), $transactionCode),
			new Date(mb_substr($codaLine, 115, 6)),
			new StatementSequenceNumber(mb_substr($codaLine, 121, 3)),
			new GlobalizationCode(mb_substr($codaLine, 124, 1))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 2) == "21";
	}
}
