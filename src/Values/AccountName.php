<?php

namespace Codelicious\Coda\Values;


use function Codelicious\Coda\Helpers\validateStringLength;

class AccountName
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
		// length 26 or 35
	    //validateStringLength($value, 26, "AccountName");
	    
	    $this->value = trim($value);
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}