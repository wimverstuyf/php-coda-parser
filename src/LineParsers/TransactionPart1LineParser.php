<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\formatDateString;
use function Codelicious\Coda\Helpers\getTrimmedData;
use function Codelicious\Coda\Helpers\trimSpace;
use Codelicious\Coda\Lines\TransactionPart1Line;
use Codelicious\Coda\Statements\SepaDirectDebit;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart1LineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return TransactionPart1Line
	 */
	public function parse(string $codaLine)
	{
		$negative = substr($codaLine, 31, 1) == "1" ? -1 : 1;
		$hasStructuredMessage = (getTrimmedData($codaLine, 61, 1) == "1")?true:false;
		if ($hasStructuredMessage) {
			$structuredMessageType = substr($codaLine, 62, 3);
			$structuredMessageFull = substr($codaLine, 65, 50);
			$structuredMessage = $this->parseStructuredMessage($structuredMessageFull, $structuredMessageType);
		}
		else {
			$message = trimSpace(substr($codaLine, 62, 53));
		}
		
		$transactionCode = getTrimmedData($codaLine, 53, 8);
		$transactionCodeFamily = getTrimmedData($transactionCode, 3, 2);
		
		if ($hasStructuredMessage && $structuredMessageType == '127')
		{
			$sepaInfo = $this->parseSepaDirectDebit($transactionCodeFamily, $structuredMessageType, $structuredMessageFull);
		}
		
		return new TransactionPart1Line(
			getTrimmedData($codaLine, 2, 4),
			getTrimmedData($codaLine, 6, 4),
			getTrimmedData($codaLine, 10, 21),
			getTrimmedData($codaLine, 32, 15) * $negative / 1000,
			formatDateString(getTrimmedData($codaLine, 47, 6)),
			$transactionCode,
			getTrimmedData($transactionCode, 1, 2),
			$transactionCodeFamily,
			getTrimmedData($transactionCode, 5, 3),
			getTrimmedData($transactionCode, 0, 1),
			$message,
			$hasStructuredMessage,
			$structuredMessageType,
			$structuredMessageFull,
			$structuredMessage,
			formatDateString(getTrimmedData($codaLine, 115, 6)),
			getTrimmedData($codaLine, 121, 3),
			getTrimmedData($codaLine, 124, 1),
			$sepaInfo
		);
	}
	
	/**
	 * @param string $transactionCodeFamily
	 * @param string $structuredMessageType
	 * @param string $structuredMessageFull
	 * @return SepaDirectDebit|null
	 */
	private function parseSepaDirectDebit(string $transactionCodeFamily, string $structuredMessageType, string $structuredMessageFull)
	{
		if ($transactionCodeFamily != '05' || $structuredMessageType != '127') {
			return null;
		}
		
		return new SepaDirectDebit(
			formatDateString(getTrimmedData($structuredMessageFull, 0, 6)),
			getTrimmedData($structuredMessageFull, 6, 1),
			getTrimmedData($structuredMessageFull, 7, 1),
			getTrimmedData($structuredMessageFull, 8, 1),
			getTrimmedData($structuredMessageFull, 9, 35),
			getTrimmedData($structuredMessageFull, 44, 35),
			getTrimmedData($structuredMessageFull, 79, 62),
			getTrimmedData($structuredMessageFull, 141, 1),
			getTrimmedData($structuredMessageFull, 142, 4)
		);
	}
	
	/**
	 * @param string $message
	 * @param string $type
	 * @return null|string
	 */
	private function parseStructuredMessage(string $message, string $type)
	{
		$structured_message = null;

		if ($type == "101" || $type == "102") {
			$structured_message = substr($message, 0, 12);
		}

		return $structured_message;
	}
	
	public function canAcceptString(string $codaLine)
	{
		return strlen($codaLine) == 128 && substr($codaLine, 0, 2) == "21";
	}
}
