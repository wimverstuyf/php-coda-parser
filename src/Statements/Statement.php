<?php

namespace Codelicious\Coda\Statements;
use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\Date;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Statement
{
	/** @var Date|null */
	private $date;
	/** @var Account */
	private $account;
	/** @var Amount|null */
	private $initialBalance;
	/** @var Amount|null */
	private $newBalance;
	/** @var string */
	private $informationalMessage;
	/** @var array */
	private $transactions;
	
	/**
	 * @param Date|null $date
	 * @param Account $account
	 * @param Amount|null $initialBalance
	 * @param Amount|null $newBalance
	 * @param string $informationalMessage
	 * @param array $transactions
	 */
	public function __construct($date, Account $account, $initialBalance, $newBalance, string $informationalMessage, array $transactions)
	{
		$this->date = $date;
		$this->account = $account;
		$this->initialBalance = $initialBalance;
		$this->newBalance = $newBalance;
		$this->informationalMessage = $informationalMessage;
		$this->transactions = $transactions;
	}
	
	/**
	 * @return Date|null
	 */
	public function getDate()
	{
		return $this->date;
	}
	
	/**
	 * @return Account
	 */
	public function getAccount(): Account
	{
		return $this->account;
	}
	
	/**
	 * @return Amount|null
	 */
	public function getInitialBalance()
	{
		return $this->initialBalance;
	}
	
	/**
	 * @return Amount|null
	 */
	public function getNewBalance()
	{
		return $this->newBalance;
	}
	
	/**
	 * @return string
	 */
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