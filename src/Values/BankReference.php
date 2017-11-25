<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringLength;

class BankReference
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
		validateStringLength($value, 21, "BankReference");
		
		$this->value = trim($value);
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}