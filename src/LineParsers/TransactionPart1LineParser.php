<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\coda2Date;
use function Codelicious\Coda\Helpers\codaStr2Data;
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
		$hasStructuredMessage = (codaStr2Data($codaLine, 61, 1) == "1")?true:false;
		if ($hasStructuredMessage) {
			$structuredMessageType = substr($codaLine, 62, 3);
			$structuredMessageFull = substr($codaLine, 65, 50);
			$structuredMessage = $this->parseStructuredMessage($structuredMessageFull, $structuredMessageType);
		}
		else {
			$message = trimSpace(substr($codaLine, 62, 53));
		}
		
		$transactionCode = codaStr2Data($codaLine, 53, 8);
		$transactionCodeFamily = codaStr2Data($transactionCode, 3, 2);
		
		if ($hasStructuredMessage && $structuredMessageType == '127')
		{
			$sepaInfo = $this->parseSepaDirectDebit($transactionCodeFamily, $structuredMessageType, $structuredMessageFull);
		}
		
		return new TransactionPart1Line(
			codaStr2Data($codaLine, 2, 4),
			codaStr2Data($codaLine, 6, 4),
			codaStr2Data($codaLine, 10, 21),
			codaStr2Data($codaLine, 32, 15) * $negative / 1000,
			coda2Date(codaStr2Data($codaLine, 47, 6)),
			$transactionCode,
			codaStr2Data($transactionCode, 1, 2),
			$transactionCodeFamily,
			codaStr2Data($transactionCode, 5, 3),
			codaStr2Data($transactionCode, 0, 1),
			$message,
			$hasStructuredMessage,
			$structuredMessageType,
			$structuredMessageFull,
			$structuredMessage,
			coda2Date(codaStr2Data($codaLine, 115, 6)),
			codaStr2Data($codaLine, 121, 3),
			codaStr2Data($codaLine, 124, 1),
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
			coda2Date(codaStr2Data($structuredMessageFull, 0, 6)),
			codaStr2Data($structuredMessageFull, 6, 1),
			codaStr2Data($structuredMessageFull, 7, 1),
			codaStr2Data($structuredMessageFull, 8, 1),
			codaStr2Data($structuredMessageFull, 9, 35),
			codaStr2Data($structuredMessageFull, 44, 35),
			codaStr2Data($structuredMessageFull, 79, 62),
			codaStr2Data($structuredMessageFull, 141, 1),
			codaStr2Data($structuredMessageFull, 142, 4)
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
