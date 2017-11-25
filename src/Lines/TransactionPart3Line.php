<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\AccountFull;
use Codelicious\Coda\Values\AccountName;
use Codelicious\Coda\Values\Message;
use Codelicious\Coda\Values\SequenceNumber;
use Codelicious\Coda\Values\SequenceNumberDetail;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class TransactionPart3Line implements LineInterface
{
	/** @var SequenceNumber */
	private $sequenceNumber;
	/** @var SequenceNumberDetail */
	private $sequenceNumberDetail;
	/** @var AccountFull */
	private $otherAccountNumberAndCurrency;
	/** @var AccountName */
	private $otherAccountName;
	/** @var Message */
	private $message;
	
	public function __construct(
		SequenceNumber $sequenceNumber,
		SequenceNumberDetail $sequenceNumberDetail,
		AccountFull $otherAccountNumberAndCurrency,
		AccountName $otherAccountName,
		Message $message )
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
	
	public function getSequenceNumber(): SequenceNumber
	{
		return $this->sequenceNumber;
	}
	
	public function getSequenceNumberDetail(): SequenceNumberDetail
	{
		return $this->sequenceNumberDetail;
	}
	
	public function getOtherAccountNumberAndCurrency(): AccountFull
	{
		return $this->otherAccountNumberAndCurrency;
	}
	
	public function getOtherAccountName(): AccountName
	{
		return $this->otherAccountName;
	}
	
	public function getMessage(): Message
	{
		return $this->message;
	}
}