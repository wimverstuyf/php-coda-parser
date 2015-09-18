<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction31Parser implements ParserInterface
{
	/**
	 * Parse the given string containing 31 into a Transaction31-object
	 *
	 * @param string $coda31_line
	 * @return object
	 */
	public function parse($coda31_line)
	{
		$coda31 = new \Codelicious\Coda\Data\Raw\Transaction31();
		
		$coda31->sequence_number = trim(substr($coda31_line, 2, 4));
		$coda31->sequence_number_detail = trim(substr($coda31_line, 6, 4));
		$coda31->bank_reference = trim(substr($coda31_line, 10, 21));
		$coda31->transaction_code = trim(substr($coda31_line, 31, 8));

		$coda31->has_structured_message = (substr($coda31_line, 39, 1) == "1")?TRUE:FALSE;
		if ($coda31->has_structured_message)
		{
			$coda31->structured_message_type = substr($coda31_line, 40, 3);
			$coda31->structured_message_full = substr($coda31_line, 43, 70);
			$coda31->structured_message = $this->parse_structured_message($coda31->structured_message_full, $coda31->structured_message_type);
		}
		else
		{
			$coda31->message = trim(substr($coda31_line, 40, 73));
		}

		return $coda31;
	}

	public function parse_structured_message($message, $type)
	{
		$structured_message = NULL;

		if ($type == "101" || $type == "102")
		{
			$structured_message = substr($message, 0, 12);
		}
		elseif ($type == "105")
		{
			$structured_message = substr($message, 42, 12);
		}

		return $structured_message;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 2) == "31";
	}
}
