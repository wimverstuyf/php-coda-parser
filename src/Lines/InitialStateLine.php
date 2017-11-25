<?php

namespace Codelicious\Coda\Lines;

use Codelicious\Coda\Values\Account;
use Codelicious\Coda\Values\Amount;
use Codelicious\Coda\Values\Date;
use Codelicious\Coda\Values\PaperStatementSequenceNumber;
use Codelicious\Coda\Values\StatementSequenceNumber;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class InitialStateLine implements LineInterface
{
	/** @var PaperStatementSequenceNumber */
	private $paperStatementSequenceNumber;
	/** @var StatementSequenceNumber */
	private $statementSequenceNumber;
	/** @var Account */
	private $account;
	/** @var Amount */
	private $balance;
	/** @var Date */
	private $date;
	
	public function __construct(
		PaperStatementSequenceNumber $paperStatementSequenceNumber,
		StatementSequenceNumber $statementSequenceNumber,
		Account $account,
		Amount $balance,
		Date $date )
	{
		
		$this->paperStatementSequenceNumber = $paperStatementSequenceNumber;
		$this->statementSequenceNumber = $statementSequenceNumber;
		$this->account = $account;
		$this->balance = $balance;
		$this->date = $date;
	}
	
	public function getType(): LineType
	{
		return new LineType(LineType::InitialState);
	}
	
	public function getPaperStatementSequenceNumber(): PaperStatementSequenceNumber
	{
		return $this->paperStatementSequenceNumber;
	}
	
	public function getStatementSequenceNumber(): StatementSequenceNumber
	{
		return $this->statementSequenceNumber;
	}
	
	public function getAccount(): Account
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