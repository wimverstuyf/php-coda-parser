<?php
namespace Codelicious\Coda;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Parser
{
	/**
	 * Parse the given array of string into an array of objects
	 *
	 * @param array $coda_lines
	 * @return array
	 */
	public function parse($coda_lines)
	{
		return NULL;
	}

	/**
	 * Read the given file and parse the content into an array of objects
	 *
	 * @param string $coda_file
	 * @return array
	 */
	public function parseFile($coda_file)
	{
		return $this->parse(file_get_contents($coda_file));
	}
}
