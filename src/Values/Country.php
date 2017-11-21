<?php

namespace Codelicious\Coda\Values;

class Country
{
	/** @var string */
	private $countryCode;
	
	public function __construct(string $countryCode)
	{
		$this->countryCode = $countryCode;
	}
	
	public function getCountryCode(): string
	{
		return $this->countryCode;
	}
}