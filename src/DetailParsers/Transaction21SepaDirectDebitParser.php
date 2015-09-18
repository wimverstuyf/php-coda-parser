<?php

namespace Codelicious\Coda\DetailParsers;

use \Codelicious\Coda\Data\Raw\Transaction21;
use Codelicious\Coda\Data\Raw\Transaction21SepaDirectDebit;

/**
 * @package Codelicious\Coda
 * @author Grummfy <me@grummfy.be>
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction21SepaDirectDebitParser extends Transaction21Parser
{
	/**
	 * Parse the given string containing 21 into a Transaction21-object
	 *
	 * @param string $coda21_line
	 * @return Transaction21SepaDirectDebit
	 */
	public function parse($coda21_line)
	{
		$coda21SDD = new Transaction21SepaDirectDebit();
		$coda21 = parent::parse($coda21_line);
		codaValueObjectCopy2Object($coda21, $coda21SDD);

		if ($coda21SDD->has_structured_message && $coda21SDD->structured_message_type == '127')
		{
			$this->parseSepaDirectDebit($coda21SDD);
		}

		return $coda21SDD;
	}

	protected function parseSepaDirectDebit(Transaction21SepaDirectDebit $coda21)
	{
		if ($coda21->transaction_code_family != '05' || $coda21->structured_message_type != '127')
		{
			return $coda21;
		}

		$coda21->sepa_direct_debit_settlement_date = coda2Date(codaStr2Data($coda21->structured_message_full, 0, 6));
		$coda21->sepa_direct_debit_type = codaStr2Data($coda21->structured_message_full, 6, 1);
		$coda21->sepa_direct_debit_scheme = codaStr2Data($coda21->structured_message_full, 7, 1);
		$coda21->sepa_direct_debit_paid_reason = codaStr2Data($coda21->structured_message_full, 8, 1);
		$coda21->sepa_direct_debit_creditor_id_code = codaStr2Data($coda21->structured_message_full, 9, 35);
		$coda21->sepa_direct_debit_mandate_ref = codaStr2Data($coda21->structured_message_full, 44, 35);
		$coda21->sepa_direct_debit_communication = codaStr2Data($coda21->structured_message_full, 79, 62);
		$coda21->sepa_direct_debit_type_r_ref = codaStr2Data($coda21->structured_message_full, 141, 1);
		$coda21->sepa_direct_debit_reason = codaStr2Data($coda21->structured_message_full, 142, 4);

		return $coda21;
	}
}
