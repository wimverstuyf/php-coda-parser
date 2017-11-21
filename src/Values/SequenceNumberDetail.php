<?php

namespace Codelicious\Coda\Values;

use UnexpectedValueException;

class SequenceNumberDetail extends UnexpectedValueException
{
	/** @var int */
	private $value;
	
	public function __construct(string $sequenceNumberDetail)
	{
		if (mb_strlen($sequenceNumberDetail) != 4) {
			throw new InvalidValueException("SequenceNumberDetail", $sequenceNumberDetail, "Value must be 4 long");
		}
		if (!ctype_digit($sequenceNumberDetail)) {
			throw new InvalidValueException("SequenceNumberDetail", $sequenceNumberDetail, "Value must be numeric");
		}
		
		$value = intval($sequenceNumberDetail);
		if ($value < 0) {
			throw new InvalidValueException("SequenceNumberDetail", $sequenceNumberDetail, "Value cannot be negative");
		}
		
		$this->value = $value;
	}
	
	public function getValue(): int
	{
		return $this->value;
	}
	
}