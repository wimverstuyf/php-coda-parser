<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringMultipleLengths;

class StructuredMessage
{
	/** @var string */
	private $structuredMessageType;
	/** @var string */
	private $structuredMessage = "";
	/** @var string */
	private $structuredMessageFull;
	/** @var SepaDirectDebit|null  */
	private $sepaDirectDebit = null;
	
	public function __construct(string $value, TransactionCode $transactionCode)
	{
		validateStringMultipleLengths($value, [53, 73], "StructuredMessage");
		
		$this->structuredMessageType = mb_substr($value, 0, 3);
		$this->structuredMessageFull = mb_substr($value, 3);
		
		if ($this->structuredMessageType == "101" || $this->structuredMessageType == "102") {
			$this->structuredMessage = mb_substr($this->structuredMessageFull, 0, 12);
		} elseif ($this->structuredMessageType == "105" && mb_strlen($this->structuredMessageFull) >= 57) {
			$this->structuredMessage = mb_substr($this->structuredMessageFull, 45, 12); // is start position 42 or 45?
		} elseif ($this->structuredMessageType == "127" && $transactionCode->getFamily()->getValue() == "05") {
			$this->sepaDirectDebit = new SepaDirectDebit($this->structuredMessageFull);
		}
	}
	
	public function getType(): string
	{
		return $this->structuredMessageType;
	}
	
	public function getStructuredMessage(): string
	{
		return $this->structuredMessage;
	}
	
	public function getAll(): string
	{
		return $this->structuredMessageFull;
	}
	
	/** @return SepaDirectDebit|null */
	public function getSepaDirectDebit()
	{
		return $this->sepaDirectDebit;
	}
}