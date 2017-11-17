<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\formatDateString;
use function Codelicious\Coda\Helpers\getTrimmedData;
use Codelicious\Coda\Lines\NewStateLine;

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
		$negative = substr($codaLine, 41, 1) == "1" ? -1 : 1;
		
		return new NewStateLine(
			getTrimmedData($codaLine, 1, 3),
			substr($codaLine, 4, 37), // don't further parse info as it is already present in coda1-line
			substr($codaLine, 42, 15)*$negative / 1000,
			formatDateString(substr($codaLine, 57, 6))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return strlen($codaLine) == 128 && substr($codaLine, 0, 1) == "8";
	}
}
