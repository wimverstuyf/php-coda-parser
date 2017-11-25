<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\getTrimmedData;
use function Codelicious\Coda\Helpers\trimSpace;
use Codelicious\Coda\Lines\TransactionPart2Line;
use Codelicious\Coda\Values\Bic;
use Codelicious\Coda\Values\CategoryPurpose;
use Codelicious\Coda\Values\ClientReference;
use Codelicious\Coda\Values\IsoReasonReturnCode;
use Codelicious\Coda\Values\Message;
use Codelicious\Coda\Values\Purpose;
use Codelicious\Coda\Values\SequenceNumber;
use Codelicious\Coda\Values\SequenceNumberDetail;
use Codelicious\Coda\Values\TransactionCodeType;

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
			new SequenceNumber(mb_substr($codaLine, 2, 4)),
			new SequenceNumberDetail(mb_substr($codaLine, 6, 4)),
			new Message(mb_substr($codaLine, 10, 53)),
			new ClientReference(mb_substr($codaLine, 63, 35)),
			new Bic(mb_substr($codaLine, 98, 11)),
			new TransactionCodeType(mb_substr($codaLine, 112, 1)),
			new IsoReasonReturnCode(mb_substr($codaLine, 113, 4)),
			new CategoryPurpose(mb_substr($codaLine, 117, 4)),
			new Purpose(mb_substr($codaLine, 121, 4))
		);
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 2) == "22";
	}
}
