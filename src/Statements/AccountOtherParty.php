<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class AccountOtherParty
{
	/** @var string */
	private $name;
	/** @var string */
	private $bic;
	/** @var string */
	private $number;
	/** @var string */
	private $currencyCode;
	
	public function __construct(string $name, string $bic, string $number, string $currencyCode)
	{
		$this->name = $name;
		$this->bic = $bic;
		$this->number = $number;
		$this->currencyCode = $currencyCode;
	}
	
	public function getName(): string
	{
		return $this->name;
	}
	
	public function getBic(): string
	{
		return $this->bic;
	}
	
	public function getNumber(): string
	{
		return $this->number;
	}
	
	public function getCurrencyCode(): string
	{
		return $this->currencyCode;
	}
}
