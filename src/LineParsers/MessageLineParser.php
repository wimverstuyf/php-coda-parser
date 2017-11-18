<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\getTrimmedData;
use Codelicious\Coda\Lines\MessageLine;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class MessageLineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return MessageLine
	 */
	public function parse(string $codaLine)
	{
		return new MessageLine(
			mb_substr($codaLine, 2, 4),
			mb_substr($codaLine, 6, 4),
			getTrimmedData($codaLine, 32, 80)
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 1) == "4";
	}
}
