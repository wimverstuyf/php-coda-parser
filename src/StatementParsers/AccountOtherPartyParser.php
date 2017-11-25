<?php

namespace Codelicious\Coda\StatementParsers;

use function Codelicious\Coda\Helpers\getFirstLineOfType;
use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\Lines\LineType;
use Codelicious\Coda\Lines\TransactionPart2Line;
use Codelicious\Coda\Lines\TransactionPart3Line;
use Codelicious\Coda\Statements\AccountOtherParty;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class AccountOtherPartyParser
{
	/**
	 * @param LineInterface[] $lines
	 * @return AccountOtherParty
	 */
	public function parse(array $lines): AccountOtherParty
	{
		/** @var TransactionPart2Line|null $transactionPart2Line */
		$transactionPart2Line = getFirstLineOfType($lines, new LineType(LineType::TransactionPart2));
		/** @var TransactionPart3Line|null $transactionPart3Line */
		$transactionPart3Line = getFirstLineOfType($lines, new LineType(LineType::TransactionPart3));
		
		$bic = "";
		if ($transactionPart2Line) {
			$bic = $transactionPart2Line->getOtherAccountBic()->getValue();
		}
		
		$number = "";
		$name = "";
		$currency = "";
		if ($transactionPart3Line) {
			$name = $transactionPart3Line->getOtherAccountName()->getValue();
			$number = $transactionPart3Line->getOtherAccountNumberAndCurrency()->getValue();
			// let's try to parse number and currency
			if ($number) {
				$lastSpace = strrpos($number, " ");
				if ($lastSpace !== false) {
					$currency = trim(mb_substr($number, $lastSpace));
					$number = trim(mb_substr($number, 0, $lastSpace));
				}
			}
		}
		
		return new AccountOtherParty(
			$name,
			$bic,
			$number,
			$currency
		);
	}
}