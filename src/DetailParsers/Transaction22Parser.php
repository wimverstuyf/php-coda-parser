<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction22Parser
{
	/**
	 * Parse the given string containing 22 into a Transaction22-object
	 *
	 * @param string $coda22_line
	 * @return object
	 */
	public function parse($coda22_line)
	{
		$coda22 = new \Codelicious\Coda\Data\Raw\Transaction22();
		
		$coda22->sequence_number = trim(substr($coda22_line, 2, 4));
		$coda22->sequence_number_detail = trim(substr($coda22_line, 6, 4));
		$coda22->message = trim(substr($coda22_line, 10, 53));
		$coda22->client_reference = trim(substr($coda22_line, 63, 35));
		$coda22->other_account_bic = trim(substr($coda22_line, 98, 11));
		$coda22->category_purpose = trim(substr($coda22_line, 117, 4));
		$coda22->purpose = trim(substr($coda22_line, 121, 4));

		return $coda22;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 2) == "22";
	}
}
