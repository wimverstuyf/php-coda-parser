<?php

namespace Codelicious\Coda\Values;

use function Codelicious\Coda\Helpers\getTrimmedData;
use function Codelicious\Coda\Helpers\validateStringMultipleLengths;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class SepaDirectDebit
{
	/** @var Date */
	private $settlementDate;
	/** @var int */
	private $type;
	/** @var int */
	private $scheme;
	/** @var int */
	private $paidReason;
	/** @var string */
	private $creditorIdentificationCode;
	/** @var string */
	private $mandateReference;
	
	public function __construct(string $value)
	{
		validateStringMultipleLengths($value, [50, 70], "SepaDirectDebit");
		
		$this->settlementDate = new Date(mb_substr($value, 0, 6));
		$this->type = (int) mb_substr($value, 6, 1);
		$this->scheme = (int) mb_substr($value, 7, 1);
		$this->paidReason = (int) mb_substr($value, 8, 1);
		$this->creditorIdentificationCode = getTrimmedData($value, 9, 35);
		$this->mandateReference = getTrimmedData($value, 44, null); //, 35);
//		$this->communication = getTrimmedData($value, 79, 62);
//		$this->typeRRef = getTrimmedData($value, 141, 1);
//		$this->reason	= getTrimmedData($value, 142, 4);
	}
	
	public function getSettlementDate(): Date
	{
		return $this->settlementDate;
	}
	
	public function getType(): int
	{
		return $this->type;
	}
	
	public function getScheme(): int
	{
		return $this->scheme;
	}
	
	public function getPaidReason(): int
	{
		return $this->paidReason;
	}
	
	public function getCreditorIdentificationCode(): string
	{
		return $this->creditorIdentificationCode;
	}
	
	public function getMandateReference(): string
	{
		return $this->mandateReference;
	}
}