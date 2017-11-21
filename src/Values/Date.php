<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\formatDateString;
use function Codelicious\Coda\Helpers\validateStringDigitOnly;
use function Codelicious\Coda\Helpers\validateStringLength;
use DateTime;

class Date
{
	/** @var DateTime */
	private $value;
	
	public function __construct(string $dateString)
	{
		validateStringLength($dateString, 6, "Date");
		validateStringDigitOnly($dateString, "Date");
		
		$this->value = new DateTime(formatDateString($dateString));
	}
	
	public function getValue(): DateTime
	{
		return $this->value;
	}
}