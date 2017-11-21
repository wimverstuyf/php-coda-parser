<?php

namespace Codelicious\Coda\StatementParsers;

use function Codelicious\Coda\Helpers\getFirstLineOfType;
use Codelicious\Coda\Lines\IdentificationLine;
use Codelicious\Coda\Lines\InitialStateLine;
use Codelicious\Coda\Lines\LineInterface;
use Codelicious\Coda\Lines\LineType;
use Codelicious\Coda\Statements\Account;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class AccountParser
{
	/**
	 * @param LineInterface[] $lines
	 * @return Account
	 */
	public function parse(array $lines): Account
	{
		/** @var IdentificationLine|null $identificationLine */
		$identificationLine = getFirstLineOfType($lines, new LineType(LineType::Identification));
		/** @var InitialStateLine|null $initialStateLine */
		$initialStateLine = getFirstLineOfType($lines, new LineType(LineType::InitialState));
		
		return new Account(
			($identificationLine?$identificationLine->getAccountName()->getValue():''),
			($identificationLine?$identificationLine->getAccountBic()->getValue():''),
			($identificationLine?$identificationLine->getAccountCompanyIdentificationNumber()->getValue():''),
			($initialStateLine?$initialStateLine->getAccount()->getNumber()->getValue():''),
			($initialStateLine?$initialStateLine->getAccount()->getCurrency()->getCurrencyCode():''),
			($initialStateLine?$initialStateLine->getAccount()->getCountry()->getCountryCode():'')
		);
	}
}