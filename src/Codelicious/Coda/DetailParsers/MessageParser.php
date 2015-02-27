<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class MessageParser
{
	/**
	 * Parse the given string containing 4 into a message-object
	 *
	 * @param string $coda4_line
	 * @return object
	 */
	public function parse($coda4_line)
	{
		$coda4 = new \Codelicious\Coda\Data\Message();
		
		$coda4->sequence_number = substr($coda4_line, 2, 4);
		$coda4->sequence_number_detail = substr($coda4_line, 6, 4);
		$coda4->content = trim(substr($coda4_line, 32, 80));

		return $coda4;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 1) == "4";
	}
}
