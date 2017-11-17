<?php

namespace Codelicious\Coda\LineParsers;
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
			"20" . substr($codaLine, 9, 2) . "-" . substr($codaLine, 7, 2) . "-" . substr($codaLine, 5, 2),
			trim(substr($codaLine, 11, 3)),
			substr($codaLine, 16, 1) == "D"?true:false,
			trim(substr($codaLine, 14, 2)),
			trim(substr($codaLine, 24, 10)),
			trim(substr($codaLine, 34, 26)),
			trim(substr($codaLine, 60, 11)),
			trim(substr($codaLine, 71, 11)),
			trim(substr($codaLine, 83, 5)),
			trim(substr($codaLine, 88, 16)),
			trim(substr($codaLine, 104, 16)),
			trim(substr($codaLine, 127, 1))
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
