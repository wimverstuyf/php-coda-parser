<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\Message;
use Codelicious\Coda\Values\SequenceNumber;
use Codelicious\Coda\Values\SequenceNumberDetail;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InformationPart3Line implements LineInterface
{
	/** @var SequenceNumber */
	private $sequenceNumber;
	/** @var SequenceNumberDetail */
	private $sequenceNumberDetail;
	/** @var Message */
	private $message;
	
	public function __construct(
		SequenceNumber $sequenceNumber,
		SequenceNumberDetail $sequenceNumberDetail,
		Message $message )
	{
		
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->message = $message;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::InformationPart3);
	}
	
	public function getSequenceNumber(): SequenceNumber
	{
		return $this->sequenceNumber;
	}
	
	public function getSequenceNumberDetail(): SequenceNumberDetail
	{
		return $this->sequenceNumberDetail;
	}
	
	public function getMessage(): Message
	{
		return $this->message;
	}
}