<?php

namespace Codelicious\Coda\DetailParsers;

use \Codelicious\Coda\Data\Raw\Transaction21;
use Codelicious\Coda\Data\Raw\Transaction21SepaDirectDebit;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction21Parser implements ParserInterface
{
	/**
	 * Parse the given string containing 21 into a Transaction21-object
	 *
	 * @param string $coda21_line
	 * @return object
	 */
	public function parse($coda21_line)
	{
		$has_structured_message = (substr($coda21_line, 61, 1) == "1")?TRUE:FALSE;
		$structured_message_type = substr($coda21_line, 62, 3);
		$coda21 = ($has_structured_message && $structured_message_type == '127') ? new Transaction21SepaDirectDebit(): new Transaction21();
		
		$coda21->sequence_number = trim(substr($coda21_line, 2, 4));
		$coda21->sequence_number_detail = trim(substr($coda21_line, 6, 4));
		$coda21->bank_reference = trim(substr($coda21_line, 10, 21));

		$negative = substr($coda21_line, 31, 1) == "0" ? -1 : 1;
		$coda21->amount = trim(substr($coda21_line, 32, 15)) * $negative / 1000;

		$coda21->valuta_date = "20" . substr($coda21_line, 51, 2) . "-" . substr($coda21_line, 49, 2) . "-" . substr($coda21_line, 47, 2);
		$coda21->transaction_code = trim(substr($coda21_line, 53, 8));

		$coda21->transaction_code_type = trim(substr($coda21->transaction_code, 0, 1));
		$coda21->transaction_code_family = trim(substr($coda21->transaction_code, 1, 2));
		$coda21->transaction_code_operation = trim(substr($coda21->transaction_code, 3, 2));
		$coda21->transaction_code_category = trim(substr($coda21->transaction_code, 5, 3));

		$coda21->has_structured_message = $has_structured_message;
		if ($coda21->has_structured_message) {
			$coda21->structured_message_type = $structured_message_type;
			$coda21->structured_message_full = substr($coda21_line, 65, 50);
			$coda21->structured_message = $this->parse_structured_message($coda21->structured_message_full, $coda21->structured_message_type);
		}
		else {
			$coda21->message = trim(substr($coda21_line, 62, 53));
		}

		$coda21->transaction_date = "20" . substr($coda21_line, 119, 2) . "-" . substr($coda21_line, 117, 2) . "-" . substr($coda21_line, 115, 2);
		$coda21->statement_sequence_number = trim(substr($coda21_line, 121, 3));
		$coda21->globalization_code = trim(substr($coda21_line, 124, 1));

		$this->parseSepaDirectDebit($coda21);

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

	protected function parseSepaDirectDebit(Transaction21 $coda21)
	{
		if ($coda21->transaction_code_family != '05' || $coda21->structured_message_type != '127')
		{
			return $coda21;
		}

		$coda21->sepa_direct_debit_settlement_date = trim(substr($coda21->structured_message_full, 0, 6));
		$coda21->sepa_direct_debit_type = trim(substr($coda21->structured_message_full, 6, 1));
		$coda21->sepa_direct_debit_scheme = trim(substr($coda21->structured_message_full, 7, 1));
		$coda21->sepa_direct_debit_paid_reason = trim(substr($coda21->structured_message_full, 8, 1));
		$coda21->sepa_direct_debit_creditor_id_code = trim(substr($coda21->structured_message_full, 9, 35));
		$coda21->sepa_direct_debit_mandate_ref = trim(substr($coda21->structured_message_full, 44, 35));
		$coda21->sepa_direct_debit_communication = trim(substr($coda21->structured_message_full, 79, 62));
		$coda21->sepa_direct_debit_type_r_ref = trim(substr($coda21->structured_message_full, 141, 1));
		$coda21->sepa_direct_debit_reason = trim(substr($coda21->structured_message_full, 142, 4));

		return $coda21;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 2) == "21";
	}
}
