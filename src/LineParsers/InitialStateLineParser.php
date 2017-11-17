<?php

namespace Codelicious\Coda\LineParsers;
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
		$accountNumberType = substr($codaLine, 1, 1);
		$negative = substr($codaLine, 42, 1) == "1" ? -1 : 1;
		
		list($accountIsIban, $accountNumber, $accountCurrency, $accountCountry) =
			$this->add_account_info(substr($codaLine, 5, 37), $accountNumberType);
		
		return new InitialStateLine(
			trim(substr($codaLine, 125, 3)),
			trim(substr($codaLine, 2, 3)),
			trim(substr($codaLine, 64, 26)),
			trim(substr($codaLine, 90, 35)),
			$accountNumberType,
			$accountNumber,
			$accountCurrency,
			$accountCountry,
			$accountIsIban,
			substr($codaLine, 43, 15)*$negative / 1000,
			"20" . substr($codaLine, 62, 2) . "-" . substr($codaLine, 60, 2) . "-" . substr($codaLine, 58, 2)
		);
	}

	private function add_account_info(string $account_info, string $account_type)
	{
		$accountIsIban = false;
		$accountNumber = "";
		$accountCurrency = "";
		$accountCountry = "";

		if ($account_type == "0") {
			$accountNumber = substr($account_info, 0, 12);
			$accountCurrency = substr($account_info, 13, 3);
			$accountCountry = substr($account_info, 17, 2);
		}
		else if ($account_type == "1") {
			$accountNumber = substr($account_info, 0, 34);
			$accountCurrency = substr($account_info, 34, 3);
		}
		else if ($account_type == "2") {
			$accountIsIban = TRUE;
			$accountNumber = substr($account_info, 0, 31);
			$accountCurrency = substr($account_info, 34, 3);
			$accountCountry = "BE";
		}
		else if ($account_type == "3") {
			$accountIsIban = true;
			$accountNumber = substr($account_info, 0, 34);
			$accountCurrency = substr($account_info, 34, 3);
		}
		
		return [$accountIsIban, $accountNumber, $accountCurrency, $accountCountry];
	}
	
	public function canAcceptString(string $codaLine)
	{
		return strlen($codaLine) == 128 && substr($codaLine, 0, 1) == "1";
	}
}
