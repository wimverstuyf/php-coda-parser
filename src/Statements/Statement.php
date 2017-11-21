<?php

namespace Codelicious\Coda\Statements;

use DateTime;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Statement
{
	/** @var DateTime */
	private $date;
	/** @var Account */
	private $account;
	/** @var float */
	private $initialBalance;
	/** @var float */
	private $newBalance;
	/** @var string */
	private $informationalMessage;
	/** @var array */
	private $transactions;
	
	/**
	 * @param DateTime $date
	 * @param Account $account
	 * @param float $initialBalance
	 * @param float $newBalance
	 * @param string $informationalMessage
	 * @param Transaction[] $transactions
	 */
	public function __construct(DateTime $date, Account $account, float $initialBalance, float $newBalance, string $informationalMessage, array $transactions)
	{
		$this->date = $date;
		$this->account = $account;
		$this->initialBalance = $initialBalance;
		$this->newBalance = $newBalance;
		$this->informationalMessage = $informationalMessage;
		$this->transactions = $transactions;
	}
	
	public function getDate(): DateTime
	{
		return $this->date;
	}
	
	public function getAccount(): Account
	{
		return $this->account;
	}
	
	public function getInitialBalance(): float
	{
		return $this->initialBalance;
	}
	
	public function getNewBalance(): float
	{
		return $this->newBalance;
	}
	
	public function getInformationalMessage(): string
	{
		return $this->informationalMessage;
	}
	
	/**
	 * @return Transaction[]
	 */
	public function getTransactions(): array
	{
		return $this->transactions;
	}
}