<?php

namespace Codelicious\Coda\DetailParsers;

/**
 * @package Codelicious\Coda
 * @author Grummfy <me@grummfy.be>
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
interface ParserInterface
{
	/**
	 * Parse the given string containing into a more readable object
	 *
	 * @param string $coda1_line
	 * @return object
	 */
	public function parse($coda1_line);

	/**
	 * Check if the parser take into account this type of line
	 *
	 * @param string $coda_line
	 * @return bool
	 */
	public function accept_string($coda_line);
}
