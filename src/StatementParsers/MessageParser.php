<?php

namespace Codelicious\Coda\StatementParsers;

use Codelicious\Coda\Lines\MessageLine;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class MessageParser
{
	/**
	 * @param MessageLine[] $lines
	 * @return string
	 */
	public function parse(array $lines): string
	{
		$messageString = "";
		
		foreach ($lines as $message) {
			$trimmed_content = trim($message->getContent()->getValue());
			if ($trimmed_content && $messageString) {
				$messageString .= " ";
			}
			$messageString .= $trimmed_content;
		}
		
		return $messageString;
	}
}