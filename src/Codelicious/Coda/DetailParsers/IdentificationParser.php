<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class IdentificationParser
{
	/**
	 * Parse the given string containing 0 into an identification-object
	 *
	 * @param string $coda0_line
	 * @return object
	 */
	public function parse($coda0_line)
	{
		$coda0 = new \Codelicious\Coda\Data\Identification();

		$coda0->creation_date = "20" . substr($coda0_line, 9, 2) . "-" . substr($coda0_line, 7, 2) . "-" . substr($coda0_line, 5, 2);
		$coda0->bank_identification_number = trim(substr($coda0_line, 11, 3));
		$coda0->application_code = trim(substr($coda0_line, 14, 2));
		$coda0->is_duplicate = substr($coda0_line, 16, 1) == "D"?TRUE:FALSE;
		$coda0->file_reference = trim(substr($coda0_line, 24, 10));
		$coda0->account_name = trim(substr($coda0_line, 34, 26));
		$coda0->account_bic = trim(substr($coda0_line, 60, 11));
		$coda0->account_company_identification_number = trim(substr($coda0_line, 71, 11));
		$coda0->external_application_code = trim(substr($coda0_line, 83, 5));
		$coda0->transaction_reference = trim(substr($coda0_line, 88, 16));
		$coda0->related_reference = trim(substr($coda0_line, 104, 16));
		$coda0->version_code = trim(substr($coda0_line, 127, 1));
		
		return $coda0;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 1) == "0";
	}
}
