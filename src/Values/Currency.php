<?php

namespace Codelicious\Coda\Values;

class Currency
{
	/** @var string */
	private $currencyCode;
	
	public function __construct(string $currencyCode)
	{
		$this->currencyCode = $currencyCode;
	}
	
	public function getCurrencyCode(): string
	{
		return $this->currencyCode;
	}
}