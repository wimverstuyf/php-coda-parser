<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringLength;

class AccountDescription
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
		validateStringLength($value, 35, "AccountDescription");
		
		$this->value = trim($value);
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}