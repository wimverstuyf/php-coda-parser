<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\getTrimmedData;
use function Codelicious\Coda\Helpers\trimSpace;
use Codelicious\Coda\Lines\InformationPart2Line;
use Codelicious\Coda\Values\Message;
use Codelicious\Coda\Values\SequenceNumber;
use Codelicious\Coda\Values\SequenceNumberDetail;

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
			new SequenceNumber(mb_substr($codaLine, 2, 4)),
			new SequenceNumberDetail(mb_substr($codaLine, 6, 4)),
			new Message(mb_substr($codaLine, 10, 105))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 2) == "32";
	}
}
