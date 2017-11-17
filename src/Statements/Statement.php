<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Statement
{
	private $date;
	private $account;
	private $initialBalance;
	private $newBalance;
	private $informationalMessage;
	private $transactions;
	private $informationMessage;
	
	public function __construct($date, $account, $initialBalance, $newBalance, $informationMessage, array $transactions)
	{
		$this->date = $date;
		$this->account = $account;
		$this->initialBalance = $initialBalance;
		$this->newBalance = $newBalance;
		$this->informationMessage = $informationMessage;
		$this->transactions = $transactions;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function getAccount()
	{
		return $this->account;
	}
	
	public function getInitialBalance()
	{
		return $this->initialBalance;
	}
	
	public function getNewBalance()
	{
		return $this->newBalance;
	}
	
	public function getInformationalMessage()
	{
		return $this->informationalMessage;
	}
	
	public function getTransactions(): array
	{
		return $this->transactions;
	}
	
}