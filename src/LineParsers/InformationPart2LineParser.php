<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\getTrimmedData;
use function Codelicious\Coda\Helpers\trimSpace;
use Codelicious\Coda\Lines\InformationPart2Line;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InformationPart2LineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return InformationPart2Line
	 */
	public function parse(string $codaLine)
	{
		return new InformationPart2Line(
			getTrimmedData($codaLine, 2, 4),
			getTrimmedData($codaLine, 6, 4),
			trimSpace(mb_substr($codaLine, 10, 105))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 2) == "32";
	}
}
