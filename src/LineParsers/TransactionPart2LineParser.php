<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\trimSpace;
use Codelicious\Coda\Lines\TransactionPart2Line;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart2LineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return TransactionPart2Line
	 */
	public function parse(string $codaLine)
	{
		return new TransactionPart2Line(
			trim(substr($codaLine, 2, 4)),
			trim(substr($codaLine, 6, 4)),
			trimSpace(substr($codaLine, 10, 53)),
			trim(substr($codaLine, 63, 35)),
			trim(substr($codaLine, 98, 11)),
			trim(substr($codaLine, 112, 1)),
			trim(substr($codaLine, 113, 4)),
			trim(substr($codaLine, 117, 4)),
			trim(substr($codaLine, 121, 4))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return strlen($codaLine) == 128 && substr($codaLine, 0, 2) == "22";
	}
}
