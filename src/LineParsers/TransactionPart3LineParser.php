<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\getTrimmedData;
use function Codelicious\Coda\Helpers\trimSpace;
use Codelicious\Coda\Lines\TransactionPart3Line;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart3LineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return TransactionPart3Line
	 */
	public function parse(string $codaLine)
	{
		return new TransactionPart3Line(
			getTrimmedData($codaLine, 2, 4),
			getTrimmedData($codaLine, 6, 4),
			getTrimmedData($codaLine, 10, 37),
			getTrimmedData($codaLine, 47, 35),
			trimSpace(substr($codaLine, 82, 43))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return strlen($codaLine) == 128 && substr($codaLine, 0, 2) == "23";
	}
}