<?php

namespace Codelicious\Coda\LineParsers;

use Codelicious\Coda\Lines\EndSummaryLine;
use Codelicious\Coda\Values\Amount;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class EndSummaryLineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return EndSummaryLine
	 */
	public function parse(string $codaLine)
	{
		return new EndSummaryLine(
			new Amount(mb_substr($codaLine, 22, 15)), // taken from the account (=debetomzet)
			new Amount(mb_substr($codaLine, 37, 15)) // added to the account (=creditomzet)
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 1) == "9";
	}
}
