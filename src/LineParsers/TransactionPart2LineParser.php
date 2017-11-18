<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\getTrimmedData;
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
			getTrimmedData($codaLine, 2, 4),
			getTrimmedData($codaLine, 6, 4),
			trimSpace(mb_substr($codaLine, 10, 53)),
			getTrimmedData($codaLine, 63, 35),
			getTrimmedData($codaLine, 98, 11),
			getTrimmedData($codaLine, 112, 1),
			getTrimmedData($codaLine, 113, 4),
			getTrimmedData($codaLine, 117, 4),
			getTrimmedData($codaLine, 121, 4)
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 2) == "22";
	}
}
