<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class MessageLine implements LineInterface
{
	private $sequenceNumber;
	private $sequenceNumberDetail;
	private $content;
	
	public function __construct(
		$sequenceNumber, 
		$sequenceNumberDetail, 
		$content)
	{
		// TODO validate
		
		$this->sequenceNumber = $sequenceNumber;
		$this->sequenceNumberDetail = $sequenceNumberDetail;
		$this->content = $content;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::Message);
	}
	
	public function getSequenceNumber()
	{
		return $this->sequenceNumber;
	}
	
	public function getSequenceNumberDetail()
	{
		return $this->sequenceNumberDetail;
	}
	
	public function getContent()
	{
		return $this->content;
	}
}