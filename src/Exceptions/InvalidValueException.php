<?php

namespace Codelicious\Coda\Exceptions;

use UnexpectedValueException;

class InvalidValueException extends UnexpectedValueException
{
	public function __construct(string $type, $value, string $errorMessage)
	{
		parent::__construct("Value \"$value\" is invalid for $type ($errorMessage)");
	}
}