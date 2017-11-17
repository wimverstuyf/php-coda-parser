<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class AccountOtherParty
{
	private $name;
	private $bic;
	private $number;
	private $currency;
	
	public function __construct($name, $bic, $number, $currency)
	{
		$this->name = $name;
		$this->bic = $bic;
		$this->number = $number;
		$this->currency = $currency;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getBic()
	{
		return $this->bic;
	}
	
	public function getNumber()
	{
		return $this->number;
	}
	
	public function getCurrency()
	{
		return $this->currency;
	}
}