<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class SummaryParser implements ParserInterface
{
	/**
	 * Parse the given string containing 9 into a Summary-object
	 *
	 * @param string $coda9_line
	 * @return object
	 */
	public function parse($coda9_line)
	{
		$coda9 = new \Codelicious\Coda\Data\Raw\Summary();
		
		$coda9->debet_amount = substr($coda9_line, 22, 15)*1/1000; // taken from the account (=debetomzet)
		$coda9->credit_amount = substr($coda9_line, 37, 15)*1/1000; // added to the account (=creditomzet)

		return $coda9;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 1) == "9";
	}
}
