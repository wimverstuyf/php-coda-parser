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
		$message = "";
		
		foreach ($lines as $message) {
			$trimmed_content = trim($message->getContent());
			if ($trimmed_content && $message) {
				$message .= " ";
			}
			$message .= $trimmed_content;
		}
		
		return $message;
	}
}