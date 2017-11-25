<?php

namespace Codelicious\Coda\LineParsers;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
interface LineParserInterface
{
	/**
	 * Parse the given string containing into a more readable object
	 *
	 * @param string $codaLine
	 * @return LineParserInterface
	 */
	public function parse(string $codaLine);

	/**
	 * Check if the parser take into account this type of line
	 *
	 * @param string $codaLine
	 * @return bool
	 */
	public function canAcceptString(string $codaLine);
}
