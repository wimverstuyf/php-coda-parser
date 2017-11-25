<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringMultipleLengths;

class MessageOrStructuredMessage
{
	/** @var StructuredMessage|null */
	private $structuredMessage;
	/** @var Message|null */
	private $message;
	
	public function __construct(string $value, TransactionCode $transactionCode)
	{
		validateStringMultipleLengths($value, [54,74], "MessageOrStructuredMessage");
 
		$hasStructuredMessage = (mb_substr($value, 0, 1) === "1")?true:false;
		$this->structuredMessage = null;
		$this->message = null;
		
		if ($hasStructuredMessage) {
			$this->structuredMessage = new StructuredMessage(mb_substr($value, 1), $transactionCode);
		} else {
			$this->message = new Message(mb_substr($value, 1));
		}
	}
	
	/** @return StructuredMessage|null */
	public function getStructuredMessage()
	{
		return $this->structuredMessage;
	}
	
	/** @return Message|null */
	public function getMessage()
	{
		return $this->message;
	}
}