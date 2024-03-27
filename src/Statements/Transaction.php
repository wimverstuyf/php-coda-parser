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
    /** @var int */
    private $statementSequence;
    /** @var int */
    private $transactionSequence;
    /** @var int */
    private $transactionSequenceDetail;
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
    /** @var TransactionCode|null */
   	private $transactionCode;
    /** @var string */
   	private $clientReference;

    /**
     * @param AccountOtherParty $account
     * @param int $statementSequence
     * @param int $transactionSequence
     * @param DateTime $transactionDate
     * @param DateTime $valutaDate
     * @param float $amount
     * @param string $message
     * @param string $structuredMessage
     * @param SepaDirectDebit|null $sepaDirectDebit
     * @param string $clientReference
     */
    public function __construct(
        AccountOtherParty $account,
        int $statementSequence,
        int $transactionSequence,
        int $transactionSequenceDetail,
        DateTime $transactionDate,
        DateTime $valutaDate,
        float $amount,
        string $message,
        string $structuredMessage,
        $sepaDirectDebit,
        TransactionCode $transactionCode,
        $clientReference
    )
    {
        $this->account = $account;
        $this->statementSequence = $statementSequence;
        $this->transactionSequence = $transactionSequence;
        $this->transactionSequenceDetail = $transactionSequenceDetail;
        $this->transactionDate = $transactionDate;
        $this->valutaDate = $valutaDate;
        $this->amount = $amount;
        $this->message = $message;
        $this->structuredMessage = $structuredMessage;
        $this->sepaDirectDebit = $sepaDirectDebit;
        $this->transactionCode = $transactionCode;
        $this->clientReference = $clientReference;
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

    /**
     * @return int
     */
    public function getStatementSequence(): int
    {
        return $this->statementSequence;
    }

    /**
     * @return int
     */
    public function getTransactionSequence(): int
    {
        return $this->transactionSequence;
    }

    /**
     * @return int
     */
    public function getTransactionSequenceDetail(): int
    {
        return $this->transactionSequenceDetail;
    }

    /**
     * @return TransactionCode
     */
    public function getTransactionCode(): TransactionCode
    {
        return $this->transactionCode;
    }

    /**
     * @return string
     */
    public function getClientReference(): string
    {
        return $this->clientReference;
    }
}
