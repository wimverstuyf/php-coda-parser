<?php

namespace Codelicious\Coda\Values;


use function Codelicious\Coda\Helpers\validateStringDigitOnly;
use function Codelicious\Coda\Helpers\validateStringLength;

class Amount
{
	/** @var float */
	private $value;
	
	public function __construct(string $amountAsString, bool $includeSign=false)
	{
		validateStringDigitOnly($amountAsString, "Amount");

		$negative = 1;
		if ($includeSign) {
			validateStringLength($amountAsString, 16, "Amount");
			
			$negative = mb_substr($amountAsString, 0, 1) === "1" ? -1 : 1;
			$amountAsString = mb_substr($amountAsString, 1, 15);
		} else {
			validateStringLength($amountAsString, 15, "Amount");
		}
		
		$this->value = $amountAsString*$negative/1000;
	}
	
	public function getValue(): float
	{
		return $this->value;
	}
}