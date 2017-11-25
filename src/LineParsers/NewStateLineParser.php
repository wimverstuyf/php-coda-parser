<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\formatDateString;
use function Codelicious\Coda\Helpers\getTrimmedData;
use Codelicious\Coda\Lines\NewStateLine;
use Codelicious\Coda\Values\AccountFull;
use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\StatementSequenceNumber;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class NewStateLineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return NewStateLine
	 */
	public function parse(string $codaLine)
	{
		return new NewStateLine(
			new StatementSequenceNumber(mb_substr($codaLine, 1, 3)),
			new AccountFull(mb_substr($codaLine, 4, 37)), // don't further parse info as it is already present in coda1-line
			new Amount(mb_substr($codaLine, 41, 16), true),
			new Date(mb_substr($codaLine, 57, 6))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 1) == "8";
	}
}
