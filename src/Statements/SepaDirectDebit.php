<?php

namespace Codelicious\Coda\Statements;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class SepaDirectDebit
{
	private $settlementDate;
	private $type;
	private $scheme;
	private $paidReason;
	private $creditorIdCode;
	private $mandateRef;
	private $communication;
	private $typeRRef;
	private $reason;
	
	public function __construct(
		$settlementDate,
		$type,
		$scheme,
		$paidReason,
		$creditorIdCode,
		$mandateRef,
		$communication,
		$typeRRef,
		$reason)
	{
		
		$this->settlementDate = $settlementDate;
		$this->type = $type;
		$this->scheme = $scheme;
		$this->paidReason = $paidReason;
		$this->creditorIdCode = $creditorIdCode;
		$this->mandateRef = $mandateRef;
		$this->communication = $communication;
		$this->typeRRef = $typeRRef;
		$this->reason = $reason;
	}
	
	public function getSettlementDate()
	{
		return $this->settlementDate;
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getScheme()
	{
		return $this->scheme;
	}
	
	public function getPaidReason()
	{
		return $this->paidReason;
	}
	
	public function getCreditorIdCode()
	{
		return $this->creditorIdCode;
	}
	
	public function getMandateRef()
	{
		return $this->mandateRef;
	}
	
	public function getCommunication()
	{
		return $this->communication;
	}
	
	public function getTypeRRef()
	{
		return $this->typeRRef;
	}
	
	public function getReason()
	{
		return $this->reason;
	}
	
}