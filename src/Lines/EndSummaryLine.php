<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\Amount;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class EndSummaryLine implements LineInterface
{
	/** @var Amount */
	private $debetAmount;
	/** @var Amount */
	private $creditAmount;
	
	public function __construct(Amount $debetAmount, Amount $creditAmount)
	{
		$this->debetAmount = $debetAmount;
		$this->creditAmount = $creditAmount;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::EndSummary);
	}
	
	public function getDebetAmount(): Amount
	{
		return $this->debetAmount;
	}
	
	public function getCreditAmount(): Amount
	{
		return $this->creditAmount;
	}
}