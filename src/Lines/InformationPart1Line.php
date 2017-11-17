<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InformationPart1Line implements LineInterface
{
	/** @var */
	private $sequenceNumber;
	/** @var */
	private $sequenceNumberDetail;
	/** @var */
	private $bankReference;
	/** @var */
	private $transactionCode;
	/** @var */
	private $message;
	/** @var bool */
	private $hasStructuredMessage;
	/** @var */
	private $structuredMessageType;
	/** @var */
	private $structuredMessageFull;
	/** @var */
	private $structuredMessage;
	
	public function __construct(
		$sequenceNumber,
		$sequenceNumberDetail,
		$bankReference,
		$transactionCode,
		$message,
		bool $hasStructuredMessage,
		$structuredMessageType,
		$structuredMessageFull,
		$structuredMessage )
	{
		
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->bankReference = $bankReference;
		$this->transactionCode = $transactionCode;
		$this->message = $message;
		$this->hasStructuredMessage = $hasStructuredMessage;
		$this->structuredMessageType = $structuredMessageType;
		$this->structuredMessageFull = $structuredMessageFull;
		$this->structuredMessage = $structuredMessage;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::InformationPart1);
	}
	
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function getSequenceNumberDetail()
	{
		return $this->sequenceNumberDetail;
	}
	
	public function getBankReference()
	{
		return $this->bankReference;
	}
	
	public function getTransactionCode()
	{
		return $this->transactionCode;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
	
	public function isHasStructuredMessage(): bool
	{
		return $this->hasStructuredMessage;
	}
	
	public function getStructuredMessageType()
	{
		return $this->structuredMessageType;
	}
	
	public function getStructuredMessageFull()
	{
		return $this->structuredMessageFull;
	}
	
	public function getStructuredMessage()
	{
		return $this->structuredMessage;
	}
}