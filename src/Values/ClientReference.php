<?php

namespace Codelicious\Coda\Values;


use function Codelicious\Coda\Helpers\validateStringLength;

class ClientReference
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
		validateStringLength($value, 35, "ClientReference");
		
		$this->value = trim($value);
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}