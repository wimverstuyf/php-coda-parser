<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\formatDateString;
use function Codelicious\Coda\Helpers\getTrimmedData;
use Codelicious\Coda\Lines\IdentificationLine;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class IdentificationLineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return IdentificationLine
	 */
	public function parse(string $codaLine)
	{
		return new IdentificationLine(
			formatDateString(substr($codaLine, 5, 6)),
			getTrimmedData($codaLine, 11, 3),
			substr($codaLine, 16, 1) == "D"?true:false,
			getTrimmedData($codaLine, 14, 2),
			getTrimmedData($codaLine, 24, 10),
			getTrimmedData($codaLine, 34, 26),
			getTrimmedData($codaLine, 60, 11),
			getTrimmedData($codaLine, 71, 11),
			getTrimmedData($codaLine, 83, 5),
			getTrimmedData($codaLine, 88, 16),
			getTrimmedData($codaLine, 104, 16),
			getTrimmedData($codaLine, 127, 1)
		);
	}
	
	/**
	 * Check if the parser take into account this type of line
	 *
	 * @param string $codaLine
	 * @return bool
	 */
	public function canAcceptString(string $codaLine)
	{
		return strlen($codaLine) == 128 && substr($codaLine, 0, 1) == "0";
	}
}
