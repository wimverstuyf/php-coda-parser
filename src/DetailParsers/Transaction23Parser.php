<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction23Parser implements ParserInterface
{
	/**
	 * Parse the given string containing 23 into a Transaction23-object
	 *
	 * @param string $coda23_line
	 * @return object
	 */
	public function parse($coda23_line)
	{
		$coda23 = new \Codelicious\Coda\Data\Raw\Transaction23();
		
		$coda23->sequence_number = trim(substr($coda23_line, 2, 4));
		$coda23->sequence_number_detail = trim(substr($coda23_line, 6, 4));
		$coda23->other_account_number_and_currency = trim(substr($coda23_line, 10, 37));
		$coda23->other_account_name = trim(substr($coda23_line, 47, 35));

		$coda23->message = trim(substr($coda23_line, 82, 43));

		return $coda23;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 2) == "23";
	}
}
