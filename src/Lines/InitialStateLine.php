<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InitialStateLine implements LineInterface
{
	/** @var */
	private $sequenceNumber;
	/** @var */
	private $statementSequenceNumber;
	/** @var */
	private $accountName;
	/** @var */
	private $accountDescription;
	/** @var */
	private $accountNumberType;
	/** @var */
	private $accountNumber;
	/** @var */
	private $accountCurrency;
	/** @var */
	private $accountCountry;
	/** @var bool */
	private $accountIsIban;
	/** @var */
	private $balance;
	/** @var */
	private $date;
	
	public function __construct(
		$sequenceNumber,
		$statementSequenceNumber,
		$accountName,
		$accountDescription,
		$accountNumberType,
		$accountNumber,
		$accountCurrency,
		$accountCountry,
		bool $accountIsIban,
		$balance,
		$date )
	{
		
		$this->sequenceNumber = $sequenceNumber;
		$this->statementSequenceNumber = $statementSequenceNumber;
		$this->accountName = $accountName;
		$this->accountDescription = $accountDescription;
		$this->accountNumberType = $accountNumberType;
		$this->accountNumber = $accountNumber;
		$this->accountCurrency = $accountCurrency;
		$this->accountCountry = $accountCountry;
		$this->accountIsIban = $accountIsIban;
		$this->balance = $balance;
		$this->date = $date;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::InitialState);
	}
	
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function getStatementSequenceNumber()
	{
		return $this->statementSequenceNumber;
	}
	
	public function getAccountName()
	{
		return $this->accountName;
	}
	
	public function getAccountDescription()
	{
		return $this->accountDescription;
	}
	
	public function getAccountNumberType()
	{
		return $this->accountNumberType;
	}
	
	public function getAccountNumber()
	{
		return $this->accountNumber;
	}
	
	public function getAccountCurrency()
	{
		return $this->accountCurrency;
	}
	
	public function getAccountCountry()
	{
		return $this->accountCountry;
	}
	
	public function isAccountIsIban(): bool
	{
		return $this->accountIsIban;
	}
	
	public function getBalance()
	{
		return $this->balance;
	}
	
	public function getDate()
	{
		return $this->date;
	}
}