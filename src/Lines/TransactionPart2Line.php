<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart2Line implements LineInterface
{
	/** @var */
	private $sequenceNumber;
	/** @var */
	private $sequenceNumberDetail;
	/** @var */
	private $message;
	/** @var */
	private $clientReference;
	/** @var */
	private $otherAccountBic;
	/** @var */
	private $transactionType;
	/** @var */
	private $isoReasonReturnCode;
	/** @var */
	private $categoryPurpose;
	/** @var */
	private $purpose;
	
	public function __construct(
		$sequenceNumber,
		$sequenceNumberDetail,
		$message,
		$clientReference,
		$otherAccountBic,
		$transactionType,
		$isoReasonReturnCode,
		$categoryPurpose,
		$purpose )
	{
		
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->message = $message;
		$this->clientReference = $clientReference;
		$this->otherAccountBic = $otherAccountBic;
		$this->transactionType = $transactionType;
		$this->isoReasonReturnCode = $isoReasonReturnCode;
		$this->categoryPurpose = $categoryPurpose;
		$this->purpose = $purpose;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::TransactionPart2);
	}
	
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function getSequenceNumberDetail()
	{
		return $this->sequenceNumberDetail;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function getClientReference()
	{
		return $this->clientReference;
	}
	
	public function getOtherAccountBic()
	{
		return $this->otherAccountBic;
	}
	
	public function getTransactionType()
	{
		return $this->transactionType;
	}
	
	public function getIsoReasonReturnCode()
	{
		return $this->isoReasonReturnCode;
	}
	
	public function getCategoryPurpose()
	{
		return $this->categoryPurpose;
	}
	
	public function getPurpose()
	{
		return $this->purpose;
	}
}