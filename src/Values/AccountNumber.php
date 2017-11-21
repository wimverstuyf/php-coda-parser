<?php

namespace Codelicious\Coda\Values;


class AccountNumber
{
	/** @var string */
	private $value;
	/** @var bool */
	private $isIbanNumber;
	
	public function __construct(string $value, bool $isIbanNumber)
	{
		$this->value = $value;
		$this->isIbanNumber = $isIbanNumber;
	}
	
	public function isIbanNumber(): bool
	{
		return $this->isIbanNumber;
	}
	
	public function getValue(): string
	{
		return $this->value;
	}
}