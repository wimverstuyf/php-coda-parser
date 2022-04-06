<?php

namespace Codelicious\Coda\StatementParsers;

use Codelicious\Coda\Lines\InformationPart1Line;
use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\Lines\LineType;
use Codelicious\Coda\Lines\TransactionPart1Line;
use Codelicious\Coda\Lines\TransactionPart2Line;
use Codelicious\Coda\Statements\Transaction;
use Codelicious\Coda\Statements\TransactionCode;
use Codelicious\Coda\Values\Message;
use DateTime;
use function Codelicious\Coda\Helpers\filterLinesOfTypes;
use function Codelicious\Coda\Helpers\getFirstLineOfType;

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
     * @throws \Exception
     */
	public function parse(array $lines): Transaction
	{
		/** @var TransactionPart1Line $transactionPart1Line */
		$transactionPart1Line = getFirstLineOfType($lines, new LineType(LineType::TransactionPart1));

		$transactionDate = new DateTime("0001-01-01");
		$valutaDate = new DateTime("0001-01-01");
		$amount = 0.0;
		$sepaDirectDebit = null;
		$transactionCode = null;

		/** @var int $statementSequence */
		$statementSequence = 0;

		/** @var int $transactionSequence */
		$transactionSequence = 0;
		/** @var int $transactionSequenceDetail */
		$transactionSequenceDetail = 0;

		if ($transactionPart1Line) {
			$valutaDate = $transactionPart1Line->getValutaDate()->getValue();
			$transactionDate = $transactionPart1Line->getTransactionDate()->getValue();
			$amount = $transactionPart1Line->getAmount()->getValue();
			$statementSequence = $transactionPart1Line->getStatementSequenceNumber()->getValue();
			$transactionSequence = $transactionPart1Line->getSequenceNumber()->getValue();
			$transactionSequenceDetail = $transactionPart1Line->getSequenceNumberDetail()->getValue();
			if ($transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()) {
				$sepaDirectDebit = $transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getSepaDirectDebit();
			}

			$valueTransactionCode = $transactionPart1Line->getTransactionCode();

			$transactionCode = new TransactionCode(
				$valueTransactionCode->getFamily()->getValue(),
				$valueTransactionCode->getType()->getValue(),
				$valueTransactionCode->getOperation()->getValue(),
				$valueTransactionCode->getCategory()->getValue()
			);
		}

		/** @var InformationPart1Line $informationPart1Line */
		$informationPart1Line = getFirstLineOfType($lines, new LineType(LineType::InformationPart1));

		$structuredMessage = "";

		if (
			$transactionPart1Line &&
			$transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage() &&
			!empty($transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage())
		) {
			$structuredMessage = $transactionPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage();
		} elseif (
			$informationPart1Line &&
			$informationPart1Line->getMessageOrStructuredMessage()->getStructuredMessage() &&
			!empty($informationPart1Line->getMessageOrStructuredMessage()->getStructuredMessage()->getStructuredMessage())
		) {
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
			$statementSequence,
			$transactionSequence,
			$transactionSequenceDetail,
			$transactionDate,
			$valutaDate,
			$amount,
			$message,
			$structuredMessage,
			$sepaDirectDebit,
			$transactionCode
		);
	}

	/**
	 * @param LineInterface[] $lines
	 * @return LineInterface[]
	 */
	public function filter(array $transactionLines)
	{
		$filteredTransactionLines = [];
		$transactionPart1LineType = new LineType(LineType::TransactionPart1);
		$informationPart1LineType = new LineType(LineType::InformationPart1);

		foreach ($transactionLines as $transactionLine) {
			/** @var TransactionPart1Line|null $transactionPart1Line */
			$transactionPart1Line = getFirstLineOfType($transactionLine, $transactionPart1LineType);
			/** @var InformationPart1Line|null $informationPart1Line */
			$informationPart1Line = getFirstLineOfType($transactionLine, $informationPart1LineType);

			if ($transactionPart1Line && $this->isCollectiveTransactionCode($transactionPart1Line->getTransactionCode()) && $transactionPart1Line->getSequenceNumberDetail()->getValue() < 2) {
				continue;
			}
			if ($informationPart1Line && $this->isCollectiveTransactionCode($informationPart1Line->getTransactionCode()) && $informationPart1Line->getSequenceNumberDetail()->getValue() < 2) {
				continue;
			}

			$filteredTransactionLines[] = $transactionLine;
		}

		return $filteredTransactionLines;
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

	private function isCollectiveTransactionCode(\Codelicious\Coda\Values\TransactionCode $transactionCode): bool
	{
		return $transactionCode->getOperation()->getValue() === '07';
	}
}
