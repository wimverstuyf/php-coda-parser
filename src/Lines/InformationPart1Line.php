<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\BankReference;
use Codelicious\Coda\Values\MessageOrStructuredMessage;
use Codelicious\Coda\Values\SequenceNumber;
use Codelicious\Coda\Values\SequenceNumberDetail;
use Codelicious\Coda\Values\TransactionCode;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InformationPart1Line implements LineInterface
{
	/** @var SequenceNumber */
	private $sequenceNumber;
	/** @var SequenceNumberDetail */
	private $sequenceNumberDetail;
	/** @var BankReference */
	private $bankReference;
	/** @var TransactionCode */
	private $transactionCode;
	/** @var MessageOrStructuredMessage */
	private $messageOrStructuredMessage;
	
	public function __construct(
		SequenceNumber $sequenceNumber,
		SequenceNumberDetail $sequenceNumberDetail,
		BankReference $bankReference,
		TransactionCode $transactionCode,
		MessageOrStructuredMessage $messageOrStructuredMessage)
	{
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->bankReference = $bankReference;
		$this->transactionCode = $transactionCode;
		$this->messageOrStructuredMessage = $messageOrStructuredMessage;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::InformationPart1);
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
	
	public function getTransactionCode(): TransactionCode
	{
		return $this->transactionCode;
	}
	
	public function getMessageOrStructuredMessage(): MessageOrStructuredMessage
	{
		return $this->messageOrStructuredMessage;
	}
}