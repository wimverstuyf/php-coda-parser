<?php

namespace Codelicious\Coda\Statements;

use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\SepaDirectDebit;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction
{
	/** @var AccountOtherParty */
	private $account;
	/** @var Date|null */
	private $transactionDate;
	/** @var Date|null */
	private $valutaDate;
	/** @var Amount|null */
	private $amount;
	/** @var string */
	private $message;
	/** @var string */
	private $structuredMessage;
	/** @var SepaDirectDebit|null */
	private $sepaDirectDebit;
	
	/**
	 * @param AccountOtherParty $account
	 * @param Date|null $transactionDate
	 * @param Date|null $valutaDate
	 * @param Amount|null $amount
	 * @param string $message
	 * @param string $structuredMessage
	 * @param SepaDirectDebit|null $sepaDirectDebit
	 */
	public function __construct(AccountOtherParty $account, $transactionDate, $valutaDate, $amount, string $message, string $structuredMessage, $sepaDirectDebit)
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
	
	public function getMessage(): string
	{
		return $this->message;
	}
	
	public function getStructuredMessage(): string
	{
		return $this->structuredMessage;
	}
	
	public function getSepaDirectDebit()
	{
		return $this->sepaDirectDebit;
	}
	
	
}