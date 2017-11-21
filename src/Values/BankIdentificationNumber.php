<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringLength;

class BankIdentificationNumber
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
	    validateStringLength($value, 3, "BankIdentificationNumber");
	    
	    $this->value = trim($value);
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}