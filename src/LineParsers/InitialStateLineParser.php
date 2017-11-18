<?php

namespace Codelicious\Coda\LineParsers;

use function Codelicious\Coda\Helpers\formatDateString;
use function Codelicious\Coda\Helpers\getTrimmedData;
use Codelicious\Coda\Lines\InitialStateLine;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InitialStateLineParser implements LineParserInterface
{
	/**
	 * @param string $codaLine
	 * @return InitialStateLine
	 */
	public function parse(string $codaLine)
	{
		$accountNumberType = mb_substr($codaLine, 1, 1);
		$negative = mb_substr($codaLine, 42, 1) == "1" ? -1 : 1;
		
		list($accountIsIban, $accountNumber, $accountCurrency, $accountCountry) =
			$this->addAccountInfo(mb_substr($codaLine, 5, 37), $accountNumberType);
		
		return new InitialStateLine(
			getTrimmedData($codaLine, 125, 3),
			getTrimmedData($codaLine, 2, 3),
			getTrimmedData($codaLine, 64, 26),
			getTrimmedData($codaLine, 90, 35),
			$accountNumberType,
			$accountNumber,
			$accountCurrency,
			$accountCountry,
			$accountIsIban,
			mb_substr($codaLine, 43, 15)*$negative / 1000,
			formatDateString(mb_substr($codaLine, 58, 6))
		);
	}

	private function addAccountInfo(string $account_info, string $account_type)
	{
		$accountIsIban = false;
		$accountNumber = "";
		$accountCurrency = "";
		$accountCountry = "";

		if ($account_type == "0") {
			$accountNumber = mb_substr($account_info, 0, 12);
			$accountCurrency = mb_substr($account_info, 13, 3);
			$accountCountry = mb_substr($account_info, 17, 2);
		}
		else if ($account_type == "1") {
			$accountNumber = mb_substr($account_info, 0, 34);
			$accountCurrency = mb_substr($account_info, 34, 3);
		}
		else if ($account_type == "2") {
			$accountIsIban = TRUE;
			$accountNumber = mb_substr($account_info, 0, 31);
			$accountCurrency = mb_substr($account_info, 34, 3);
			$accountCountry = "BE";
		}
		else if ($account_type == "3") {
			$accountIsIban = true;
			$accountNumber = mb_substr($account_info, 0, 34);
			$accountCurrency = mb_substr($account_info, 34, 3);
		}
		
		return [$accountIsIban, $accountNumber, $accountCurrency, $accountCountry];
	}
	
	public function canAcceptString(string $codaLine)
	{
		return mb_strlen($codaLine) == 128 && mb_substr($codaLine, 0, 1) == "1";
	}
}
