<?php

namespace Codelicious\Coda\Lines;

/**
 * @package Codelicious\Coda
 * @author Wim Verstuyf (wim.verstuyf@codelicious.be)
 * @license http://opensource.org/licenses/GPL-2.0 GPL-2.0
 */
class NewStateLine implements LineInterface
{
	/** @var */
	private $statementSequenceNumber;
	/** @var */
	private $account;
	/** @var */
	private $balance;
	/** @var */
	private $date;
	
	public function __construct(
		$statementSequenceNumber,
		$account,
		$balance,
		$date )
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
	
	public function getStatementSequenceNumber()
	{
		return $this->statementSequenceNumber;
	}
	
	public function getAccount()
	{
		return $this->account;
	}
	
	public function getBalance()
	{
		return $this->balance;
	}
	
	public function getDate()
	{
		return $this->date;
	}
}