<?php

namespace Codelicious\Coda\Values;

class SequenceNumber
{
	/** @var int */
	private $value;
	
	public function __construct(string $sequenceNumber)
	{
	    if (mb_strlen($sequenceNumber) != 4) {
	    	throw new InvalidValueException("SequenceNumber", $sequenceNumber, "Value must be 4 long");
	    }
		if (!ctype_digit($sequenceNumber)) {
			throw new InvalidValueException("SequenceNumber", $sequenceNumber, "Value must be numeric");
		}
		
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