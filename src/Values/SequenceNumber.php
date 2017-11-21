<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringDigitOnly;
use function Codelicious\Coda\Helpers\validateStringLength;

class SequenceNumber
{
	/** @var int */
	private $value;
	
	public function __construct(string $sequenceNumber)
	{
		validateStringLength($sequenceNumber, 4, "SequenceNumber");
		validateStringDigitOnly($sequenceNumber, "SequenceNumber");
		
		$value = intval($sequenceNumber);
	    if ($value < 0) {
		    throw new InvalidValueException("SequenceNumber", $sequenceNumber, "Value cannot be negative");
	    }
		
		$this->value = $value;
	}
	
	public function getValue(): int
	{
		return $this->value;
	}
}