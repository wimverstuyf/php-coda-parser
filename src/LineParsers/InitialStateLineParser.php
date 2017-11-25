<?php

namespace Codelicious\Coda\LineParsers;

use Codelicious\Coda\Lines\InitialStateLine;
use Codelicious\Coda\Values\Account;
use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\PaperStatementSequenceNumber;
use Codelicious\Coda\Values\StatementSequenceNumber;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InitialStateLineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return InitialStateLine
	 */
	public function parse(string $codaLine)
	{
		return new InitialStateLine(
			new PaperStatementSequenceNumber(mb_substr($codaLine, 125, 3)),
			new StatementSequenceNumber(mb_substr($codaLine, 2, 3)),
			new Account(mb_substr($codaLine, 1, 1), mb_substr($codaLine, 5, 37), mb_substr($codaLine, 64, 61)),
			new Amount(mb_substr($codaLine, 42, 16), true),
			new Date(mb_substr($codaLine, 58, 6))
		);
	}

	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 1) == "1";
	}
}
