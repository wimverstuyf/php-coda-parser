<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction21Parser
{
	/**
	 * Parse the given string containing 21 into a Transaction21-object
	 *
	 * @param string $coda21_line
	 * @return object
	 */
	public function parse($coda21_line)
	{
		$coda21 = new \Codelicious\Coda\Data\Raw\Transaction21();
		
		$coda21->sequence_number = trim(substr($coda21_line, 2, 4));
		$coda21->sequence_number_detail = trim(substr($coda21_line, 6, 4));
		$coda21->bank_reference = trim(substr($coda21_line, 10, 21));

		$negative = substr($coda21_line, 31, 1) == "0" ? -1 : 1;
		$coda21->amount = trim(substr($coda21_line, 32, 15)) * $negative / 1000;

		$coda21->valuta_date = "20" . substr($coda21_line, 51, 2) . "-" . substr($coda21_line, 49, 2) . "-" . substr($coda21_line, 47, 2);
		$coda21->transaction_code = trim(substr($coda21_line, 53, 8));

		$coda21->has_structured_message = (substr($coda21_line, 61, 1) == "1")?TRUE:FALSE;
		if ($coda21->has_structured_message) {
			$coda21->structured_message_type = substr($coda21_line, 62, 3);
			$coda21->structured_message_full = substr($coda21_line, 65, 50);
			$coda21->structured_message = $this->parse_structured_message($coda21->structured_message_full, $coda21->structured_message_type);
		}
		else {
			$coda21->message = trim(substr($coda21_line, 62, 53));
		}

		$coda21->transaction_date = "20" . substr($coda21_line, 119, 2) . "-" . substr($coda21_line, 117, 2) . "-" . substr($coda21_line, 115, 2);
		$coda21->statement_sequence_number = trim(substr($coda21_line, 121, 3));
		$coda21->globalization_code = trim(substr($coda21_line, 124, 1));

		return $coda21;
	}

	public function parse_structured_message($message, $type)
	{
		$structured_message = NULL;

		if ($type == "101" || $type == "102") {
			$structured_message = substr($message, 0, 12);
		}

		return $structured_message;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 2) == "21";
	}
}
