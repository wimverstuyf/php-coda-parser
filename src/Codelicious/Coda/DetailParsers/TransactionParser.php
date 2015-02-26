<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionParser
{
	/**
	 * Parse the given string containing 2 or 3 into a Transaction-object
	 *
	 * @param string $coda23_line
	 * @return object
	 */
	public function parse($coda23_line)
	{
		$coda23 = new \Codelicious\Coda\Data\Transaction();
		
		return $coda23;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && (substr($coda_line, 0, 1) == "2" || substr($coda_line, 0, 1) == "3");
	}
}
