<?php

namespace Codelicious\Coda\Values;


use function Codelicious\Coda\Helpers\validateStringLength;
use function Codelicious\Coda\Helpers\validateStringMultipleLengths;

class AccountName
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
	    validateStringMultipleLengths($value, [26, 35], "AccountName");
	    
	    $this->value = trim($value);
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}