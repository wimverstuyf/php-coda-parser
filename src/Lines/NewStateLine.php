<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\AccountFull;
use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\StatementSequenceNumber;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class NewStateLine implements LineInterface
{
	/** @var StatementSequenceNumber */
	private $statementSequenceNumber;
	/** @var AccountFull */
	private $account;
	/** @var Amount */
	private $balance;
	/** @var Date */
	private $date;
	
	public function __construct(
		StatementSequenceNumber $statementSequenceNumber,
		AccountFull $account,
		Amount $balance,
		Date $date )
	{
		$this->statementSequenceNumber = $statementSequenceNumber;
		$this->account = $account;
		$this->balance = $balance;
		$this->date = $date;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::NewState);
	}
	
	public function getStatementSequenceNumber(): StatementSequenceNumber
	{
		return $this->statementSequenceNumber;
	}
	
	public function getAccount(): AccountFull
	{
		return $this->account;
	}
	
	public function getBalance(): Amount
	{
		return $this->balance;
	}
	
	public function getDate(): Date
	{
		return $this->date;
	}
}