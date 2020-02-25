<?php

namespace Codelicious\Coda\Statements;

use Codelicious\Coda\Values\SepaDirectDebit;
use DateTime;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class Transaction
{
	/** @var AccountOtherParty */
	private $account;
	/** @var DateTime */
	private $transactionDate;
	/** @var DateTime */
	private $valutaDate;
	/** @var float */
	private $amount;
	/** @var string */
	private $message;
	/** @var string */
	private $structuredMessage;
	/** @var SepaDirectDebit|null */
	private $sepaDirectDebit;
	/** @var string|null */
    private $statementSequence;
    /** @var string|null */
    private $transactionSequence;
    /** @var string|null */
    private $transactionSequenceDetail;

    /**
     * @param AccountOtherParty $account
     * @param DateTime $transactionDate
     * @param DateTime $valutaDate
     * @param float $amount
     * @param string $message
     * @param string $structuredMessage
     * @param SepaDirectDebit|null $sepaDirectDebit
     * @param $statementSequence
     * @param $transactionSequence
     * @param $transactionSequenceDetail
     */
	public function __construct(
	    AccountOtherParty $account,
        DateTime $transactionDate,
        DateTime $valutaDate,
        float $amount,
        string $message,
        string $structuredMessage,
        $sepaDirectDebit,
        $statementSequence,
        $transactionSequence,
        $transactionSequenceDetail
    )
	{
		$this->account = $account;
		$this->transactionDate = $transactionDate;
		$this->valutaDate = $valutaDate;
		$this->amount = $amount;
		$this->message = $message;
		$this->structuredMessage = $structuredMessage;
		$this->sepaDirectDebit = $sepaDirectDebit;
        $this->statementSequence = $statementSequence;
        $this->transactionSequence = $transactionSequence;
        $this->transactionSequenceDetail = $transactionSequenceDetail;
    }

	public function getAccount(): AccountOtherParty
	{
		return $this->account;
	}

	public function getTransactionDate(): DateTime
	{
		return $this->transactionDate;
	}

	public function getValutaDate(): DateTime
	{
		return $this->valutaDate;
	}

	public function getAmount(): float
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

	/**
	 * @return SepaDirectDebit|null
	 */
	public function getSepaDirectDebit()
	{
		return $this->sepaDirectDebit;
	}


}
