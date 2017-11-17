<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction
{
	private $account;
	private $transactionDate;
	private $valutaDate;
	private $amount;
	private $message;
	private $structuredMessage;
	/** @var SepaDirectDebit|null */
	private $sepaDirectDebit;
	
	public function __construct(AccountOtherParty $account, $transactionDate, $valutaDate, $amount, $message, $structuredMessage, $sepaDirectDebit)
	{
		$this->account = $account;
		$this->transactionDate = $transactionDate;
		$this->valutaDate = $valutaDate;
		$this->amount = $amount;
		$this->message = $message;
		$this->structuredMessage = $structuredMessage;
		$this->sepaDirectDebit = $sepaDirectDebit;
	}
	
	/**
	 * @return AccountOtherParty
	 */
	public function getAccount()
	{
		return $this->account;
	}
	
	public function getTransactionDate()
	{
		return $this->transactionDate;
	}
	
	public function getValutaDate()
	{
		return $this->valutaDate;
	}
	
	public function getAmount()
	{
		return $this->amount;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function getStructuredMessage()
	{
		return $this->structuredMessage;
	}
	
	public function getSepaDirectDebit()
	{
		return $this->sepaDirectDebit;
	}
}