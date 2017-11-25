<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringLength;

class Purpose
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
		validateStringLength($value, 4, "Purpose");
		
		$this->value = trim($value);
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}