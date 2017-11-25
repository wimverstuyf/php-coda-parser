<?php

namespace Codelicious\Coda\Values;


use function Codelicious\Coda\Helpers\validateStringDigitOnly;
use function Codelicious\Coda\Helpers\validateStringLength;

class StatementSequenceNumber
{
	/** @var int */
	private $value;
	
	public function __construct(string $value)
	{
		validateStringLength($value, 3, "StatementSequenceNumber");
		validateStringDigitOnly($value, "StatementSequenceNumber");
		
		$this->value = (int)$value;
	}
	
	public function getValue(): int
	{
		return $this->value;
	}
}