<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringDigitOnly;
use function Codelicious\Coda\Helpers\validateStringLength;

class PaperStatementSequenceNumber
{
	/** @var int */
	private $value;
	
	public function __construct(string $paperStatementSequenceNumber)
	{
		validateStringLength($paperStatementSequenceNumber, 3, "PaperStatementSequenceNumber");
		validateStringDigitOnly($paperStatementSequenceNumber, "PaperStatementSequenceNumber");
		
		$value = intval($paperStatementSequenceNumber);
		if ($value < 0) {
			throw new InvalidValueException("PaperStatementSequenceNumber", $paperStatementSequenceNumber, "Value cannot be negative");
		}
		
		$this->value = $value;
	}
	
	public function getValue(): int
	{
		return $this->value;
	}
}