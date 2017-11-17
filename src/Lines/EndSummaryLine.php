<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class EndSummaryLine implements LineInterface
{
	/** @var */
	private $debetAmount;
	/** @var */
	private $creditAmount;
	
	public function __construct($debetAmount, $creditAmount)
	{
		$this->debetAmount = $debetAmount;
		$this->creditAmount = $creditAmount;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::EndSummary);
	}
	
	public function getDebetAmount()
	{
		return $this->debetAmount;
	}
	
	public function getCreditAmount()
	{
		return $this->creditAmount;
	}
}