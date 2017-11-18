<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\getTrimmedData;
use function Codelicious\Coda\Helpers\trimSpace;
use Codelicious\Coda\Lines\InformationPart1Line;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InformationPart1LineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return InformationPart1Line
	 */
	public function parse(string $codaLine)
	{
		$hasStructuredMessage = (mb_substr($codaLine, 39, 1) == "1")?TRUE:FALSE;
		$structuredMessageType = "";
		$structuredMessageFull = "";
		$structuredMessage = "";
		$message = "";
		if ($hasStructuredMessage) {
			$structuredMessageType = mb_substr($codaLine, 40, 3);
			$structuredMessageFull = mb_substr($codaLine, 43, 70);
			$structuredMessage = $this->parseStructuredMessage($structuredMessageFull, $structuredMessageType);
		} else {
			$message = trimSpace(mb_substr($codaLine, 40, 73));
		}
		
		return new InformationPart1Line(
			getTrimmedData($codaLine, 2, 4),
			getTrimmedData($codaLine, 6, 4),
			getTrimmedData($codaLine, 10, 21),
			getTrimmedData($codaLine, 31, 8),
			$message,
			$hasStructuredMessage,
			$structuredMessageType,
			$structuredMessageFull,
			$structuredMessage
		);
	}

	public function parseStructuredMessage($message, $type)
	{
		$structuredMessage = null;

		if ($type == "101" || $type == "102") {
			$structuredMessage = mb_substr($message, 0, 12);
		} elseif ($type == "105") {
			$structuredMessage = mb_substr($message, 42, 12);
		}

		return $structuredMessage;
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 2) == "31";
	}
}
