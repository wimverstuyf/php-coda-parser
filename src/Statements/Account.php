<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Account
{
	/** @var string */
	private $name;
	/** @var string */
	private $bic;
	/** @var string */
	private $companyIdentificationNumber;
	/** @var string */
	private $number;
	/** @var string */
	private $currencyCode;
	/** @var string */
	private $countryCode;
	/** @var string */
	private $description;

	public function __construct(string $name, string $bic, string $companyIdentificationNumber, string $number, string $currencyCode, string $countryCode, string $description)
	{
		$this->name = $name;
		$this->bic = $bic;
		$this->companyIdentificationNumber = $companyIdentificationNumber;
		$this->number = $number;
		$this->currencyCode = $currencyCode;
		$this->countryCode = $countryCode;
		$this->description = $description;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getBic(): string
	{
		return $this->bic;
	}

	public function getCompanyIdentificationNumber(): string
	{
		return $this->companyIdentificationNumber;
	}

	public function getNumber(): string
	{
		return $this->number;
	}

	public function getCurrencyCode(): string
	{
		return $this->currencyCode;
	}

	public function getCountryCode(): string
	{
		return $this->countryCode;
	}

	public function getDescription(): string
	{
		return $this->description;
	}
}
