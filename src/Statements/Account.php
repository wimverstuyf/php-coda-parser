<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Account
{
	private $name;
	private $bic;
	private $companyIdentificationNumber;
	private $number;
	private $currency;
	private $country;
	
	public function __construct($name, $bic, $companyIdentificationNumber, $number, $currency, $country)
	{
		$this->name = $name;
		$this->bic = $bic;
		$this->companyIdentificationNumber = $companyIdentificationNumber;
		$this->number = $number;
		$this->currency = $currency;
		$this->country = $country;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getBic()
	{
		return $this->bic;
	}
	
	public function getCompanyIdentificationNumber()
	{
		return $this->companyIdentificationNumber;
	}
	
	public function getNumber()
	{
		return $this->number;
	}
	
	public function getCurrency()
	{
		return $this->currency;
	}
	
	public function getCountry()
	{
		return $this->country;
	}
}
