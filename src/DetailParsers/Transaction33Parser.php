<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction33Parser implements ParserInterface
{
	/**
	 * Parse the given string containing 33 into a Transaction33-object
	 *
	 * @param string $coda33_line
	 * @return object
	 */
	public function parse($coda33_line)
	{
		$coda33 = new \Codelicious\Coda\Data\Raw\Transaction33();
		
		$coda33->sequence_number = trim(substr($coda33_line, 2, 4));
		$coda33->sequence_number_detail = trim(substr($coda33_line, 6, 4));
		$coda33->message = trim_space(substr($coda33_line, 10, 90));

		return $coda33;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 2) == "33";
	}
}
