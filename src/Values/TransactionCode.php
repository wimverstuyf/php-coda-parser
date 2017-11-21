<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\validateStringDigitOnly;
use function Codelicious\Coda\Helpers\validateStringLength;

class TransactionCode
{
	/** @var TransactionCodeFamily */
	private $family;
	/** @var TransactionCodeType */
	private $type;
	/** @var TransactionCodeOperation */
	private $operation;
	/** @var TransactionCodeCategory */
	private $category;
	
	public function __construct(string $value)
	{
		validateStringLength($value, 8, "TransactionCode");
		validateStringDigitOnly($value, "TransactionCode");
		
		$this->type = new TransactionCodeType(mb_substr($value, 0, 1));
		$this->family = new TransactionCodeFamily(mb_substr($value, 1, 2));
		$this->operation = new TransactionCodeOperation(mb_substr($value, 3, 2));
		$this->category = new TransactionCodeCategory(mb_substr($value, 5, 3));
	}
	
	public function getType(): TransactionCodeType
	{
		return $this->type;
	}
	
	public function getFamily(): TransactionCodeFamily
	{
		return $this->family;
	}
	
	public function getOperation(): TransactionCodeOperation
	{
		return $this->operation;
	}
	
	public function getCategory(): TransactionCodeCategory
	{
		return $this->category;
	}
}