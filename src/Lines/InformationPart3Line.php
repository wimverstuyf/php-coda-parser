<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InformationPart3Line implements LineInterface
{
	/** @var */
	private $sequenceNumber;
	/** @var */
	private $sequenceNumberDetail;
	/** @var */
	private $message;
	
	public function __construct(
		$sequenceNumber,
		$sequenceNumberDetail,
		$message )
	{
		
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->message = $message;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::InformationPart3);
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
}