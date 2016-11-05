<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class NewSituationParser implements ParserInterface
{
	/**
	 * Parse the given string containing 8 into an NewSituation-object
	 *
	 * @param string $coda8_line
	 * @return object
	 */
	public function parse($coda8_line)
	{
		$coda8 = new \Codelicious\Coda\Data\Raw\NewSituation();
	
		$coda8->account = substr($coda8_line, 4, 37); // don't parse info as it is already present in coda1-line (OriginalSituation)
		$coda8->statement_sequence_number = trim(substr($coda8_line, 1, 3));
		$coda8->date = "20" . substr($coda8_line, 61, 2) . "-" . substr($coda8_line, 59, 2) . "-" . substr($coda8_line, 57, 2);

		$negative = substr($coda8_line, 41, 1) == "1" ? -1 : 1;
		$coda8->balance = substr($coda8_line, 42, 15)*$negative / 1000;

		return $coda8;
	}

	public function accept_string($coda_line)
	{
		return strlen($coda_line) == 128 && substr($coda_line, 0, 1) == "8";
	}
}
