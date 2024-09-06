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

		if (!$transactionPart1Line) {
			throw new \Exception('invalid transaction');
		}

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

		$transactionPart2Line = getFirstLineOfType($lines, new LineType(LineType::TransactionPart2));
		$clientReference = '';
		if ($transactionPart2Line !== null && !empty($transactionPart2Line->getClientReference()->getValue())) {
			$clientReference = $transactionPart2Line->getClientReference()->getValue();
		}

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
			$transactionCode,
			$clientReference
		);
	}

	/**
	 * @param array $groupedTransactionLines
	 * @return array
	 */
	public function filter(array $groupedTransactionLines): array
	{
		$filteredTransactionLines = [];
		$transactionPart1LineType = new LineType(LineType::TransactionPart1);

		foreach ($groupedTransactionLines as $idx=>$transactionLines) {
			/** @var TransactionPart1Line|null $transactionPart1Line */
			$transactionPart1Line = getFirstLineOfType($transactionLines, $transactionPart1LineType);

			if (!$transactionPart1Line) {
				continue;
			}

			if ($transactionPart1Line &&
				($transactionPart1Line->getTransactionCode()->getOperation()->getValue() === '07' || $transactionPart1Line->getTransactionCode()->getType()->getValue() === '1') &&
				$transactionPart1Line->getGlobalizationCode()->getValue() > 0) {

				$nextTransactionPart1Line = null;
				for($t=$idx+1; $t<count($groupedTransactionLines); $t++) {
					$nextTransactionPart1Line = getFirstLineOfType($groupedTransactionLines[$t], $transactionPart1LineType);
					if ($nextTransactionPart1Line) {
						break;
					}
				}

				if ($nextTransactionPart1Line &&
					($nextTransactionPart1Line->getTransactionCode()->getOperation()->getValue() === '07' || $nextTransactionPart1Line->getTransactionCode()->getType()->getValue() === '5') &&
					$nextTransactionPart1Line->getGlobalizationCode()->getValue() < $transactionPart1Line->getGlobalizationCode()->getValue()) {

					continue;
				}
			}

			$filteredTransactionLines[] = $transactionLines;
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
                    $message = $line->getMessageOrStructuredMessage()->getStructuredMessage() !== null ?
                        new Message($line->getMessageOrStructuredMessage()->getStructuredMessage()->getAll()) :
                        $line->getMessageOrStructuredMessage()->getMessage();
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
