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
use Codelicious\Coda\Values\Message;
use DateTime;

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

		$transactionDate = new DateTime("0001-01-01");
		$valutaDate = new DateTime("0001-01-01");
		$amount = 0.0;
		$sepaDirectDebit = null;
		if ($transactionPart1Line) {
			$valutaDate = $transactionPart1Line->getValutaDate()->getValue();
			$transactionDate = $transactionPart1Line->getTransactionDate()->getValue();
			$amount = $transactionPart1Line->getAmount()->getValue();
			if ($transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()) {
				$sepaDirectDebit = $transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getSepaDirectDebit();
			}
		}
		
		/** @var InformationPart1Line $informationPart1Line */
		$informationPart1Line = getFirstLineOfType($lines, new LineType(LineType::InformationPart1));

		$structuredMessage = "";
		if ($transactionPart1Line && $transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage() && !empty($transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage())) {
			$structuredMessage = $transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage();
		} elseif ($informationPart1Line && $informationPart1Line->getMessageOrStructuredMessage()->getStructuredMessage() && !empty($informationPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage())) {
			$structuredMessage = $informationPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage();
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
				/** @var Message|null $message */
				$message = null;
				if (method_exists($line, 'getMessageOrStructuredMessage')) {
					$message = $line->getMessageOrStructuredMessage()->getMessage();
				} else {
					$message = $line->getMessage();
				}
				return $message?$message->getValue():"";
			}, $transactionLines));
		
		if (!$message) {
			/** @var TransactionPart2Line|null $transactionLine */
			$transactionLine = getFirstLineOfType($lines, new LineType(LineType::TransactionPart2));
			if ($transactionLine && !empty($transactionLine->getClientReference()->getValue())) {
				$message = $transactionLine->getClientReference()->getValue();
			}

			$informationLines = filterLinesOfTypes(
				$lines,
				[
					new LineType(LineType::InformationPart1),
					new LineType(LineType::InformationPart2),
					new LineType(LineType::InformationPart3)
				]);
			
			if ($message) {
				$message .= " ";
			}
			$message .= implode('', array_map(function($line) {
				/** @var Message|null $message */
				$message = null;
				if (method_exists($line, 'getMessageOrStructuredMessage')) {
					$message = $line->getMessageOrStructuredMessage()->getMessage();
				} else {
					$message = $line->getMessage();
				}
				return $message?$message->getValue():"";
			}, $informationLines));
		}
		
		return trim($message);
	}
}