<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart3Line implements LineInterface
{
	/** @var */
	private $sequenceNumber;
	/** @var */
	private $sequenceNumberDetail;
	/** @var */
	private $otherAccountNumberAndCurrency;
	/** @var */
	private $otherAccountName;
	/** @var */
	private $message;
	
	public function __construct(
		$sequenceNumber,
		$sequenceNumberDetail,
		$otherAccountNumberAndCurrency,
		$otherAccountName,
		$message )
	{
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->otherAccountNumberAndCurrency = $otherAccountNumberAndCurrency;
		$this->otherAccountName = $otherAccountName;
		$this->message = $message;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::TransactionPart3);
	}
	
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function getSequenceNumberDetail()
	{
		return $this->sequenceNumberDetail;
	}
	
	public function getOtherAccountNumberAndCurrency()
	{
		return $this->otherAccountNumberAndCurrency;
	}
	
	public function getOtherAccountName()
	{
		return $this->otherAccountName;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
}