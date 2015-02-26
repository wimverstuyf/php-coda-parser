<?php

namespace Codelicious\Coda;

/**
 * array(
 *       {
 * 			identification :
 * 			new_situation :
 * 			movements : array( )
 * 			messages : array( )
 * 			old_situation :
 * 			summary :
 *       }
 *      )
 * 
 * 0 -> identification (beginopname) [required]
 * 1 -> old situation (oud saldo) [required]
 * 
 *   2 -> movement (beweging)
 *   3 -> information (aanvullende informatie)
 * 
 * 8 -> new situation (nieuw saldo) [required]
 * 4 -> messages
 * 9 -> summary (eindopname) [required]
 * 
 * empty file: 0, 1, 9
 */

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
		// if ($identification->version_code != "2")
		//   throw "Version not supported"
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
