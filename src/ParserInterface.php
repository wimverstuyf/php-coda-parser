<?php

namespace Codelicious\Coda;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
interface ParserInterface
{
	public function parseFile(string $codaFile): array;
	
	/**
	 * @param string[] $codaLines
	 * @return array
	 */
	public function parse(array $codaLines): array;
}