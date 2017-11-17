<?php

namespace Codelicious\Coda\LineParsers;
use Codelicious\Coda\Lines\EndSummaryLine;

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
			substr($codaLine, 22, 15)*1/1000, // taken from the account (=debetomzet)
			substr($codaLine, 37, 15)*1/1000 // added to the account (=creditomzet)
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return strlen($codaLine) == 128 && substr($codaLine, 0, 1) == "9";
	}
}
