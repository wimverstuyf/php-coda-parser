<?php

namespace Codelicious\Coda\StatementParsers;

use function Codelicious\Coda\Helpers\filterLinesOfTypes;
use function Codelicious\Coda\Helpers\getFirstLineOfType;
use Codelicious\Coda\Lines\InformationPart1Line;
use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\Lines\LineType;
use Codelicious\Coda\Lines\TransactionPart1Line;
use Codelicious\Coda\Lines\TransactionPart2Line;
use Codelicious\Coda\Statements\Transaction;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionParser
{
	/**
	 * @param array $lines
	 * @return Transaction
	 */
	public function parse(array $lines): Transaction
	{
		/** @var TransactionPart1Line $transactionPart1Line */
		$transactionPart1Line = getFirstLineOfType($lines, new LineType(LineType::TransactionPart1));

		$transactionDate = "";
		$valutaDate = "";
		$amount = 0;
		$sepaDirectDebit = null;
		if ($transactionPart1Line) {
			$valutaDate = $transactionPart1Line->getValutaDate();
			$transactionDate = $transactionPart1Line->getTransactionDate();
			$amount = $transactionPart1Line->getAmount();
			$sepaDirectDebit = $transactionPart1Line->getSepaDirectDebit();
		}
		
		/** @var InformationPart1Line $informationPart1Line */
		$informationPart1Line = getFirstLineOfType($lines, new LineType(LineType::InformationPart1));

		$structuredMessage = "";
		if ($transactionPart1Line && !empty($transactionPart1Line->getStructuredMessage())) {
			$structuredMessage = $transactionPart1Line->getStructuredMessage();
		} elseif ($informationPart1Line && !empty($informationPart1Line->getStructuredMessage())) {
			$structuredMessage = $informationPart1Line->getStructuredMessage();
		}

		$linesWithAccountInfo = filterLinesOfTypes(
			$lines,
			[
				new LineType(LineType::TransactionPart2),
				new LineType(LineType::TransactionPart3)
			]);
		
		$accountOtherPartyParser = new AccountOtherPartyParser();
		$account = $accountOtherPartyParser->parse($linesWithAccountInfo);
		
		$message = $this->constructMessage($lines);
		
		return new Transaction(
			$account,
			$transactionDate,
			$valutaDate,
			$amount,
			$message,
			$structuredMessage,
			$sepaDirectDebit
		);
	}
	
	/**
	 * @param LineInterface[] $lines
	 * @return string
	 */
	private function constructMessage(array $lines)
	{
		$transactionLines = filterLinesOfTypes(
			$lines,
			[
				new LineType(LineType::TransactionPart1),
				new LineType(LineType::TransactionPart2),
				new LineType(LineType::TransactionPart3)
			]);
		
		$message = implode('', array_map(function($line) {
				$line->getMessage();
			}, $transactionLines));
		
		if (!$message) {
			$informationLines = filterLinesOfTypes(
				$lines,
				[
					new LineType(LineType::InformationPart1),
					new LineType(LineType::InformationPart2),
					new LineType(LineType::InformationPart3)
				]);
			
			$message = implode('', array_map(function($line) {
				$line->getMessage();
			}, $informationLines));
		}
		
		if (!$message) {
			/** @var TransactionPart2Line|null $transactionLine */
			$transactionLine = getFirstLineOfType($lines, new LineType(LineType::TransactionPart2));
			if ($transactionLine) {
				$message = $transactionLine->getClientReference();
			}
		}
		
		return trim($message);
	}
}