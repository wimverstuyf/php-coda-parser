<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\BankReference;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\GlobalizationCode;
use Codelicious\Coda\Values\MessageOrStructuredMessage;
use Codelicious\Coda\Values\SequenceNumber;
use Codelicious\Coda\Values\SequenceNumberDetail;
use Codelicious\Coda\Values\StatementSequenceNumber;
use Codelicious\Coda\Values\TransactionCode;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart1Line implements LineInterface
{
	/** @var SequenceNumber */
	private $sequenceNumber;
	/** @var SequenceNumberDetail */
	private $sequenceNumberDetail;
	/** @var BankReference */
	private $bankReference;
	/** @var Amount */
	private $amount;
	/** @var Date */
	private $valutaDate;
	/** @var TransactionCode */
	private $transactionCode;
	/** @var MessageOrStructuredMessage */
	private $messageOrStructuredMessage;
	/** @var Date */
	private $transactionDate;
	/** @var StatementSequenceNumber */
	private $statementSequenceNumber;
	/** @var GlobalizationCode */
	private $globalizationCode;

	public function __construct(
		SequenceNumber $sequenceNumber,
		SequenceNumberDetail $sequenceNumberDetail,
		BankReference $bankReference,
		Amount $amount,
		Date $valutaDate,
		TransactionCode $transactionCode,
		MessageOrStructuredMessage $messageOrStructuredMessage,
		Date $transactionDate,
		StatementSequenceNumber $statementSequenceNumber,
		GlobalizationCode $globalizationCode )
	{
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->bankReference = $bankReference;
		$this->amount = $amount;
		$this->valutaDate = $valutaDate;
		$this->transactionCode = $transactionCode;
		$this->messageOrStructuredMessage = $messageOrStructuredMessage;
		$this->transactionDate = $transactionDate;
		$this->statementSequenceNumber = $statementSequenceNumber;
		$this->globalizationCode = $globalizationCode;
	}

	public function getType(): LineType
	{
		return new LineType(LineType::TransactionPart1);
	}

	public function getSequenceNumber(): SequenceNumber
	{
		return $this->sequenceNumber;
	}

	public function getSequenceNumberDetail(): SequenceNumberDetail
	{
		return $this->sequenceNumberDetail;
	}

	public function getBankReference(): BankReference
	{
		return $this->bankReference;
	}

	public function getAmount(): Amount
	{
		return $this->amount;
	}

	public function getValutaDate(): Date
	{
		return $this->valutaDate;
	}

	public function getTransactionCode(): TransactionCode
	{
		return $this->transactionCode;
	}

	public function getMessageOrStructuredMessage(): MessageOrStructuredMessage
	{
		return $this->messageOrStructuredMessage;
	}

	public function getTransactionDate(): Date
	{
		return $this->transactionDate;
	}

	public function getStatementSequenceNumber(): StatementSequenceNumber
	{
		return $this->statementSequenceNumber;
	}

	public function getGlobalizationCode(): GlobalizationCode
	{
		return $this->globalizationCode;
	}
}
