<?php

namespace Codelicious\Coda\StatementParsers;

use function Codelicious\Coda\Helpers\filterLinesOfTypes;
use function Codelicious\Coda\Helpers\getFirstLineOfType;
use Codelicious\Coda\Lines\IdentificationLine;
use Codelicious\Coda\Lines\InformationPart1Line;
use Codelicious\Coda\Lines\InformationPart2Line;
use Codelicious\Coda\Lines\InformationPart3Line;
use Codelicious\Coda\Lines\InitialStateLine;
use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\Lines\LineType;
use Codelicious\Coda\Lines\NewStateLine;
use Codelicious\Coda\Lines\TransactionPart1Line;
use Codelicious\Coda\Lines\TransactionPart2Line;
use Codelicious\Coda\Lines\TransactionPart3Line;
use Codelicious\Coda\Statements\Statement;
use DateTime;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class StatementParser
{
	/**
	 * @param LineInterface[] $lines
	 * @return Statement
	 */
	public function parse(array $lines): Statement
	{
		$date = new DateTime("0001-01-01");
		/** @var IdentificationLine $identificationLine */
		$identificationLine = getFirstLineOfType($lines, new LineType(LineType::Identification));
		if ($identificationLine) {
			$date = $identificationLine->getCreationDate()->getValue();
		}
		
		$initialBalance = 0.0;
		/** @var InitialStateLine $initialStateLine */
		$initialStateLine = getFirstLineOfType($lines, new LineType(LineType::InitialState));
		if ($initialStateLine) {
			$initialBalance = $initialStateLine->getBalance()->getValue();
		}
		
		$newBalance = 0.0;
		/** @var NewStateLine $newStateLine */
		$newStateLine = getFirstLineOfType($lines, new LineType(LineType::NewState));
		if ($newStateLine) {
			$newBalance = $newStateLine->getBalance()->getValue();
		}
		
		$messageParser = new MessageParser();
		$informationalMessage = $messageParser->parse(
			filterLinesOfTypes(
				$lines,
				[
					new LineType(LineType::Message)
				]
			));
		
		$accountParser = new AccountParser();
		$account = $accountParser->parse(
			filterLinesOfTypes(
				$lines,
				[
					new LineType(LineType::Identification),
					new LineType(LineType::InitialState)
				]
			)
		);
		
		$transactionLines = $this->groupTransactions(
			filterLinesOfTypes(
				$lines,
				[
					new LineType(LineType::TransactionPart1),
					new LineType(LineType::TransactionPart2),
					new LineType(LineType::TransactionPart3),
					new LineType(LineType::InformationPart1),
					new LineType(LineType::InformationPart2),
					new LineType(LineType::InformationPart3)
				]
			)
		);
			
		$transactionParser = new TransactionParser();
		$transactions = array_map(
			function(array $lines) use ($transactionParser) {
				return $transactionParser->parse($lines);
			}, $transactionLines);
		
		return new Statement(
			$date,
			$account,
			$initialBalance,
			$newBalance,
			$informationalMessage,
			$transactions
		);
	}
	
	/**
	 * @param LineInterface[] $lines
	 * @return LineInterface[][]
	 */
	private function groupTransactions(array $lines): array
	{
		$transactions = [];
		$idx = -1;
		$sequenceNumber = -1;
		
		foreach ($lines as $line) {
			/** @var TransactionPart1Line|TransactionPart2Line|TransactionPart3Line|InformationPart1Line|InformationPart2Line|InformationPart3Line $transactionOrInformationLine */
			$transactionOrInformationLine = $line;
			
			if (!$transactions || $sequenceNumber != $transactionOrInformationLine->getSequenceNumber()->getValue()) {
				$sequenceNumber = $transactionOrInformationLine->getSequenceNumber()->getValue();
				$idx += 1;
				
				$transactions[$idx] = [];
			}
			
			$transactions[$idx][] = $transactionOrInformationLine;
		}
		
		return $transactions;
	}
}