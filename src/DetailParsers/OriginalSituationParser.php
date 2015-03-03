<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class OriginalSituationParser
{
	/**
	 * Parse the given string containing 1 into an OriginalSituation-object
	 *
	 * @param string $coda1_line
	 * @return object
	 */
	public function parse($coda1_line)
	{
		$coda1 = new \Codelicious\Coda\Data\Raw\OriginalSituation();
		
		$coda1->account_number_type = substr($coda1_line, 1, 1);
		$coda1->statement_sequence_number = trim(substr($coda1_line, 2, 3));

		$this->add_account_info($coda1, substr($coda1_line, 5, 37), $coda1->account_number_type);

		$coda1->date = "20" . substr($coda1_line, 62, 2) . "-" . substr($coda1_line, 60, 2) . "-" . substr($coda1_line, 58, 2);

		$negative = substr($coda1_line, 42, 1) == "0" ? -1 : 1;
		$coda1->balance = substr($coda1_line, 43, 15)*$negative / 1000;

		$coda1->account_name = trim(substr($coda1_line, 64, 26));
		$coda1->account_description = trim(substr($coda1_line, 90, 35));
		$coda1->sequence_number = trim(substr($coda1_line, 125, 3));

		return $coda1;
	}

	private function add_account_info(&$coda1, $account_info, $account_type)
	{
		if ($account_type == "0") {
			$coda1->account_number = substr($account_info, 0, 12);
			$coda1->account_currency = substr($account_info, 13, 3);
			$coda1->account_country = substr($account_info, 17, 2);
		}
		else if ($account_type == "1") {
			$coda1->account_number = substr($account_info, 0, 34);
			$coda1->account_currency = substr($account_info, 34, 3);
		}
		else if ($account_type == "2") {
			$coda1->is_iban = TRUE;
			$coda1->account_number = substr($account_info, 0, 31);
			$coda1->account_currency = substr($account_info, 34, 3);
			$coda1->account_country = "BE";
		}
		else if ($account_type == "3") {
			$coda1->is_iban = TRUE;
			$coda1->account_number = substr($account_info, 0, 34);
			$coda1->account_currency = substr($account_info, 34, 3);
		}
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 1) == "1";
	}
}
