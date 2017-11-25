<?php

namespace Codelicious\Coda\Values;


use function Codelicious\Coda\Helpers\validateStringLength;

class TransactionCodeOperation
{
	/** @var string */
	private $value;
	
	public function __construct(string $value)
	{
		validateStringLength($value, 2, "TransactionCodeOperation");
		
		$this->value = $value;
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}